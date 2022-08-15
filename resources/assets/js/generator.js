import _ from 'lodash';
import * as DATA from './data';
import FORMULASMAP from './formulas';
import Jarvis from './helpers';

class Generator {

    constructor(options) {
        this.level = DATA.levels[options.level];
        this.options = options;
        this.rule = this.getRule();
        this.ruleColumns = this.getRuleColumns();
    }

    getRule() {
      const rule = parseInt(this.options.level, 10);
      return Number.isNaN(rule) ? true : rule;
    }

    getRuleColumns() {
      return DATA.ruleColumns[this.options.minmax];
    }

    getColumnWithRandomFormula() {

        const { nums, level, subtraction } = this.options;
        // const { levelTaboo } = this;

        const randomFormula = subtraction
            ? _.sample(FORMULASMAP[level])
            : _.sample(Jarvis.plusRulesOnly(FORMULASMAP[level]));

        const rule = parseInt(randomFormula, 10);
        const starter = null;

        console.log('random formula', randomFormula)

        const ruleIndex = this.isMateNegative(randomFormula)
            ? _.random(2, nums - 1)
            : this.level === 'bro' && this.rule > 0 && !subtraction
                ? _.sample(DATA.broRuleIndexVariants[nums])
                : _.random(1, nums - 1);


        const column = this[
            Jarvis.getRequiredFormulaHandler(randomFormula, subtraction)
        ](
            randomFormula,
            rule,
            nums,
            ruleIndex,
            starter,
            DATA[`${this.level}Taboo`][randomFormula]
        );


        return column;
    }

    getColumnWithRequiredFormulas() {
        const { requiredFormulas, nums, subtraction } = this.options;
        const headFormula = requiredFormulas[0];
        let starter = null;
        let lens;

        if (requiredFormulas.length === 1) {
            lens = [nums];
        } else {
            // вычисляем индексы минусовых формул из категории друг в массиве обязательных формул
            const mateNegativeFormulasIndices = requiredFormulas
                .filter(f => this.isMateNegative(f))
                .map(f => requiredFormulas.indexOf(f));

            // вычисляем массив с длинами кусочков примеров для каждой обязательной формулы
            lens = Jarvis.getLens(
                nums,
                requiredFormulas.length,
                mateNegativeFormulasIndices
            );
        }
        const tailFormulas = requiredFormulas.slice(1);
        const tailLens = lens.slice(1);

        const ruleIndex = this.isMateNegative(headFormula)
            ? _.random(2, lens[0] - 1)
            : this.level === 'bro' && this.rule > 0 && !subtraction
                ? _.sample(DATA.broRuleIndexVariants[lens[0]])
                : _.random(1, lens[0] - 1);


        const headFormulaChunk = this[
            Jarvis.getRequiredFormulaHandler(headFormula, subtraction)
        ](
            headFormula,
            parseInt(headFormula, 10),
            lens[0],
            ruleIndex,
            starter,
            DATA[`${this.level}Taboo`][headFormula]
        );
        const column = [headFormulaChunk];

        if (tailFormulas.length > 0) {
            starter = _.sum(headFormulaChunk);


            for (let i = 0; i < tailFormulas.length; i++) {
                let rule = parseInt(tailFormulas[i], 10);


                let tailFormulaChunk = this[
                    Jarvis.getRequiredFormulaHandler(tailFormulas[i], subtraction)
                ](
                    tailFormulas[i],
                    rule,
                    tailLens[i],
                    _.random(
                        this.isMateNegative(tailFormulas[i]) ? 2 : 1,
                        tailLens[i] - 1
                    ),
                    starter,
                    DATA[`${this.level}Taboo`][tailFormulas[i]]
                );

                let isBadChunk = tailFormulaChunk.some(n => !n);

                if (isBadChunk) return this.getColumnWithRequiredFormulas();


                starter += _.sum(tailFormulaChunk);
                column.push(tailFormulaChunk);
            }
        }


        return _.flatten(column);
    }

    getTask() {
        const leader =
            this.level === 'direct'
                ? this.options.subtraction
                    ? this.handleDirectCountWithSubtraction()
                    : this.handleDirectCount()
                : this.options.requiredFormulas.length === 0
                    ? this.getColumnWithRandomFormula()
                    : this.getColumnWithRequiredFormulas();

        if (this.ruleColumns === 1) {
            return leader;
        }

        const restColumns = _.range(this.ruleColumns - 1).map(x =>
            Jarvis.getTailColumn(
                this.options.nums,
                0,
                DATA[`${this.level}Taboo`][this.options.level],
                Jarvis.getOperationsMap(leader),
                this.options.level === "прямой счёт к 4"
            )
        );

        const columns =
            this.options.minmax === 'от 1 до 99' ||
                this.options.minmax === 'от 1 до 999'
                ? _.shuffle([leader, ...restColumns])
                : [leader, ...restColumns];

        const concatenated = _.reduce(columns, Jarvis.concatColumns);


        const task = _.zipWith(
            Jarvis.getOperationsMap(leader),
            concatenated,
            (a, b) => a + b
        ).map(x => parseInt(x, 10));


        return task;
    }

    handleDirectCount() {
        // console.log('taboo', this.levelTaboo)
        const task =
            this.options.max === 4
                ? Jarvis.getChildDirectCount(this.options.nums, 0, [1, -1, 2, -2, 3, -3, 4, -4])
                : Jarvis.getDirectCount(this.options.nums, 0, [1, -1, 2, -2, 3, -3, 4, -4]);

        return task;
    }

    handleDirectCountWithSubtraction() {
        const task =
            this.options.max === 4
                ? Jarvis.getChildDirectCountWithSubtraction(
                    this.options.nums,
                    0,
                    [1, -1, 2, -2, 3, -3, 4, -4]
                )
                : Jarvis.getDirectCountWithSubtraction(
                    this.options.nums,
                    0,
                    [1, -1, 2, -2, 3, -3, 4, -4]
                );


        return task;
    }

    handleBro(formula, rule, nums, index, starter, levelTaboo) {
        // const { rule } = this;
        // const { nums } = this.options;


        let task = null;

        if (nums === 2) return [_.sample(DATA.beforeSumVariants.bro[rule]), rule];

        const max = 9;
        // const index = _.random(1, nums - 1); // индекс под которым правило появится в массиве чисел примера


        // before - массив с числами предшествующими правилу в массиве чисел примера
        const beforeLen = index;
        // after - массив с числами следующими после правила в массиве чисел примера
        const afterLen = nums - (beforeLen + 1);


        const beforeSum = _.sample(
            DATA.beforeSumVariants.bro[rule]
                .filter(el => el >= beforeLen)
                // el плюс правило и минимальная сумма массива before не должны превышать max
                .filter(el => el <= max - (rule + afterLen))
        );


        // task = Jarvis.makeArr(beforeSum, beforeLen).concat(rule);

        task = Jarvis.getChunkSimple(
            // вернёт массив чисел суммой меньше пять, поэтому проверять на выполнение правил не нужно
            beforeSum,
            beforeLen,
            !!starter ? starter : +starter
        ).concat(rule);

        if (!afterLen) return task;

        // const afterSum = _.sample(
        //   _.range(1, max - _.sum(task)).filter(el => el >= afterLen)
        // );

        const afterSum = _.random(afterLen, max - _.sum(task));


        task = task.concat(
            Jarvis.getChunkSimple(_.random(afterLen, afterSum), afterLen, 0)
        );


        return task;
    }

    handleMate(formula, rule, nums, index, starter, levelTaboo) {
        // const { rule } = this;
        // const { nums } = this.options;

        // const max = 9;
        // const index = _.random(1, nums - 1);
        const beforeLen = index;
        const afterLen = nums - (beforeLen + 1);
        const beforeSum = _.sample(
            DATA.beforeSumVariants.mate[rule].filter(el => el >= beforeLen)
        );
        const before = Jarvis.getChunkSimple(
            // вернёт массив чисел суммой меньше 9, поэтому проверять на выполнение правил не нужно
            beforeSum,
            beforeLen,
            !!starter ? starter : +starter
        );

        let task;

        task = before.concat(rule);

        if (!afterLen) {
            return task;
        }

        const after = Jarvis.getPlusMateAfter(
            afterLen,
            _.sum(task),
            levelTaboo.slice(1)
        );

        task = task.concat(after);


        return task;
    }

    handleBroWithSubtraction(formula, rule, nums, index, starter, levelTaboo) {
        // const { nums } = this.options;
        // const min = 1;
        // const max = 9;
        // const { rule } = this;
        // const index = _.random(1, nums - 1);



        const beforeLen = index;
        let afterLen = nums - (beforeLen + 1);

        // const beforeSum = _.sample(
        //   DATA.beforeSumVariants.bro[rule].filter(
        //     el => el >= beforeLen && el <= max - rule - afterLen
        //   )
        // );


        let before = Jarvis.getBroBeforeForRequiredFormula(
            rule,
            beforeLen,
            !!starter ? starter : +starter,
            levelTaboo
        );

        let task = before.concat(rule);

 

        if (afterLen) {
            let after = Jarvis.getBroAfter(
                afterLen,
                _.sum(!!starter ? [starter + _.sum(task)] : task),
                levelTaboo
            );


            return task.concat(after);
        }


        return task;
    }

    handlePlusBroWithSubtraction( formula, rule, nums, index, starter, levelTaboo) {
        // const { nums } = this.options;
        // const min = 1;
        // const max = 9;
        // const { rule } = this;
        // const index = _.random(1, nums - 1);


        const beforeLen = index;
        let afterLen = nums - (beforeLen + 1);

        // const beforeSum = _.sample(DATA.beforeSumVariants.bro[rule]);

        let task;

        let before = Jarvis.getBroBeforeForRequiredFormula(
            rule,
            beforeLen,
            !!starter ? starter : +starter,
            levelTaboo
        );

        task = before.concat(rule);


        if (afterLen) {
            let after = Jarvis.getBroAfter(
                afterLen,
                _.sum(!!starter ? [starter + _.sum(task)] : task),
                levelTaboo
            );


            return task.concat(after);
        }


        return task;
    }

    isBroPositive(formula) {
        return !formula.includes('10') && parseInt(formula, 10) > 0;
    }

    isBroNegative(formula) {
        return !formula.includes('10') && parseInt(formula, 10) < 0;
    }

    isMatePositive(formula) {
        return formula.includes('10') && parseInt(formula, 10) > 0;
    }

    isMateNegative(formula) {
        return formula.includes('10') && parseInt(formula, 10) < 0;
    }

    handlePlusMateWithSubtraction( formula, rule, nums, index, starter, levelTaboo) {
        // const { nums } = this.options;
        // const { rule } = this;
        // const index = _.random(1, nums - 1);



        const beforeLen = index;
        let afterLen = nums - (beforeLen + 1);

        // const beforeSum = _.sample(
        //   DATA.beforeSumVariants.mate[rule].filter(el => el >= beforeLen)
        //   // .filter(el => max >= el + rule + afterLen)
        // );

        let before;
        let after;
        let task;


        before = Jarvis.getMateBeforeForRequiredFormula(
            rule,
            beforeLen,
            !!starter ? starter : +starter,
            levelTaboo
        );

        task = before.concat(rule);

        if (afterLen) {
            after = Jarvis.getMateAfter(
                afterLen,
                _.sum(!!starter ? [starter + _.sum(task)] : task),
                levelTaboo
            );

            task = task.concat(after);

            return task;
        }


        return task;
    }

    handleMateWithSubtraction(formula, rule, nums, index, starter, levelTaboo) {
        // const { nums } = this.options;
        // const { rule } = this;
        // const max = 9;
        // const index = _.random(2, nums - 1); // before sum будет не менее 10, поэтому индекс правила не может быть равен 1



        const beforeLen = index;
        let afterLen = nums - (index + 1);

        // const beforeSum = _.sample(DATA.beforeSumVariants.mate[rule]);

        let before;
        let after;
        let task;


        before = Jarvis.getMateBeforeForRequiredFormula(
            rule,
            beforeLen,
            !!starter ? starter : +starter,
            levelTaboo
        );

        task = before.concat(rule);


        if (afterLen > 0) {
            after = Jarvis.getMateAfter(
                afterLen,
                _.sum(!!starter ? [starter + _.sum(task)] : task),
                levelTaboo
            );

            task = task.concat(after);

            return task;
        }


        return task;
    }

    generateTasks() {
        const { quantity } = this.options;
        const tasks = [];

        for (let i = 0; i < quantity; i++) {
            tasks.push(this.getTask());
        }

        return tasks;

        // return [this.getTask()]
    }
}

export default Generator