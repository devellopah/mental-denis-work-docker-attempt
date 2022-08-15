import _ from 'lodash';
import Generator from './generator';

function getLens(nums, quantity, mateNegativeFormulasIndices) {
    const arr = [];

    const minLen = 2;

    let numsLeft = nums - mateNegativeFormulasIndices.length * 3;

    quantity = quantity - mateNegativeFormulasIndices.length;

    let iterations = quantity;

    for (var i = 1; i < iterations; i++) {
        const len = _.random(minLen, _.round(numsLeft / quantity));

        arr.push(len);

        numsLeft -= len;
        quantity -= 1;
    }

    arr.push(numsLeft);

    if (mateNegativeFormulasIndices.length > 0) {
        for (i = 0; i < mateNegativeFormulasIndices.length; i++) {
            arr.splice(mateNegativeFormulasIndices[i], 0, 3);
        }
    }

    return arr;
}

function getBroAfter(
    len,
    starter,
    taboo,
    sumVariants = [1, 2, 3, 4, 5, 6, 7, 8, 9]
) {
    var sums = _.range(len).reduce(
        (list, next) => {
            var head = _.last(list);
            var picked = _.sample(
                sumVariants.filter(variant => {
                    if (variant === head) return false;
                    if (
                        _.includes(taboo, head - variant) &&
                        (Math.min(head, variant) < 5 && Math.max(head, variant) >= 5)
                    )
                        return false;
                    return variant;
                })
            );

            return list.concat(picked);
        },
        [starter]
    );

    var chunk = [];

    sums.reduce((prev, next) => {
        chunk.push(next - prev);
        return next;
    });

    return chunk;
}

function getMateAfter(len, starter, taboo) {
    const nums = _.range(-9, 9);

    const sums = _.range(len).reduce(
        (list, next, i, arr) => {
            const head = _.last(list);

            const sumVariants = nums.map(n => _.add(head, n)).filter(n => n > 0);

            const filtered = _.filter(sumVariants, variant => {
                if (_.isEqual(head, variant)) return false;
                // if(_.includes(taboo, _.subtract(head, variant)) && !_.isEqual(_.floor(head, -1), _.floor(variant, -1))) return false;

                if (
                    _.includes(taboo, _.subtract(variant, head)) &&
                    !_.isEqual(_.floor(head, -1), _.floor(variant, -1))
                )
                    return false;
                return variant;
            });

            const picked = _.sample(filtered);

            return list.concat(picked);
        },
        [starter]
    );

    const chunk = [];

    sums.reduce((prev, next) => {
        chunk.push(next - prev);
        return next;
    });

    return chunk;
}

function getChunkSimple(sum, len, starter) {
    if (sum === len) {
        let before = _.fill(Array(len), 1);        return before;
    }

    let before = [];
    let iterations = len;
    let availableSum = sum - getLastDigit(starter);

    while (iterations) {
        if (iterations === 1) {
            before.push(availableSum);
            break;
        }

        const num = _.random(1, availableSum - iterations);
        before.push(num);

        availableSum -= num;
        iterations -= 1;
    }

    return before;
}

function getPlusMateAfter(len, starter, taboo) {
    const nums = _.range(-9, 10);

    const sums = _.range(len).reduce(
        (list, next, i, arr) => {
            const head = _.last(list);

            const sumVariants = nums.map(n => _.add(head, n)).filter(n => n > head);

            const filtered = _.filter(sumVariants, variant => {
                if (_.isEqual(head, variant)) return false;
                if (
                    _.includes(taboo, _.subtract(variant, head)) &&
                    !_.isEqual(_.floor(head, -1), _.floor(variant, -1))
                )
                    return false;
                return variant;
            });

            const picked = _.sample(filtered);

            return list.concat(picked);
        },
        [starter]
    );

    const chunk = [];

    sums.reduce((prev, next) => {
        chunk.push(next - prev);
        return next;
    });

    return chunk;
}

function getDirectCount(
    len, // длина не может быть больше 5, в противном случае, должно быть выполниться правило, а этого допустить нельзя
    starter,
    taboo
) {
    const candidates = {
        1: [1, 2, 3, 4, 5, 6, 7, 8, 9],
        2: [1, 2, 3, 4, 5, 6, 7, 8],
        3: [1, 2, 5, 6, 7],
        4: [1, 2, 5, 6],
        5: [1, 5]
    };

    let sum = starter;

    const sums = [sum];

    while (len) {
        const filtered = candidates[len].filter(variant => {
            if (variant <= sum) return false;
            if (_.includes(taboo, variant - sum) && (sum < 5 && variant >= 5))
                return false;

            return variant;
        });

        sum = _.sample(filtered);
        sums.push(sum);
        len -= 1;
    }

    const chunk = [];

    sums.reduce((prev, next) => {
        chunk.push(next - prev);
        return next;
    });

    return chunk;
}

function getDirectCountWithSubtraction(
    len, // длина не может быть больше 5, в противном случае, должно быть выполниться правило, а этого допустить нельзя
    starter,
    taboo
) {
    const candidates = [1, 2, 3, 4, 5, 6, 7, 8, 9];

    let sum = starter;

    const sums = [sum];

    while (len) {
        const filtered = candidates.filter(variant => {
            if (variant === sum) return false;
            if (
                _.includes(taboo, variant - sum) &&
                (Math.min(sum, variant) < 5 && Math.max(sum, variant) >= 5)
            )
                return false;

            return variant;
        });

        sum = _.sample(filtered);
        sums.push(sum);
        len -= 1;
    }

    const chunk = [];

    sums.reduce((prev, next) => {
        chunk.push(next - prev);
        return next;
    });

    return chunk;
}

function getChildDirectCount(
    len, // длина не может быть больше 5, в противном случае, должно быть выполниться правило, а этого допустить нельзя
    starter,
    taboo
) {
    const candidates = {
        1: [1, 2, 3, 4],
        2: [1, 2, 3],
        3: [1, 2],
        4: [1]
    };

    let sum = starter;

    const sums = [sum];

    while (len) {
        const filtered = candidates[len].filter(variant => {
            if (variant <= sum) return false;
            if (_.includes(taboo, variant - sum) && (sum < 5 && variant >= 5))
                return false;

            return variant;
        });

        sum = _.sample(filtered);
        sums.push(sum);
        len -= 1;
    }

    const chunk = [];

    sums.reduce((prev, next) => {
        chunk.push(next - prev);
        return next;
    });

    return chunk;
}

function getChildDirectCountWithSubtraction(
    len, // длина не может быть больше 5, в противном случае, должно быть выполниться правило, а этого допустить нельзя
    starter,
    taboo
) {
    const candidates = [1, 2, 3, 4];

    let sum = starter;
    let counter = len;

    const sums = [sum];

    while (counter) {
        const filtered = candidates.filter(variant => {
            if (variant === sum) return false;
            if (len > 2 && variant === _.nth(sums, -2)) return false;
            if (
                _.includes(taboo, variant - sum) &&
                (Math.min(sum, variant) < 5 && Math.max(sum, variant) >= 5)
            )
                return false;

            return variant;
        });

        sum = _.sample(filtered);
        sums.push(sum);
        counter -= 1;
    }

    const chunk = [];

    sums.reduce((prev, next) => {
        chunk.push(next - prev);
        return next;
    });

    return chunk;
}

function getRequiredFormulaHandler(formula, withSubtraction) {
    let map;

    if (withSubtraction) {
        map = {
            '+1 = +5-4': 'handlePlusBroWithSubtraction',
            '-1 = -5+4': 'handleBroWithSubtraction',
            '+2 = +5-3': 'handlePlusBroWithSubtraction',
            '-2 = -5+3': 'handleBroWithSubtraction',
            '+3 = +5-2': 'handlePlusBroWithSubtraction',
            '-3 = -5+2': 'handleBroWithSubtraction',
            '+4 = +5-1': 'handlePlusBroWithSubtraction',
            '-4 = -5+1': 'handleBroWithSubtraction',
            '+1 = -9+10': 'handlePlusMateWithSubtraction',
            '+2 = -8+10': 'handlePlusMateWithSubtraction',
            '+3 = -7+10': 'handlePlusMateWithSubtraction',
            '+4 = -6+10': 'handlePlusMateWithSubtraction',
            '+5 = -5+10': 'handlePlusMateWithSubtraction',
            '-1 = -10+9': 'handleMateWithSubtraction',
            '-2 = -10+8': 'handleMateWithSubtraction',
            '-3 = -10+7': 'handleMateWithSubtraction',
            '-4 = -10+6': 'handleMateWithSubtraction',
            '-5 = -10+5': 'handleMateWithSubtraction',
            '+9 = -1+10': 'handlePlusMateWithSubtraction',
            '-9 = -10+1': 'handleMateWithSubtraction',
            '+8 = -2+10': 'handlePlusMateWithSubtraction',
            '-8 = -10+2': 'handleMateWithSubtraction',
            '+7 = -3+10': 'handlePlusMateWithSubtraction',
            '-7 = -10+3': 'handleMateWithSubtraction',
            '+6 = -4+10': 'handlePlusMateWithSubtraction',
            '-6 = -10+4': 'handleMateWithSubtraction'
        };
    } else {
        map = {
            '+1 = +5-4': 'handleBro',
            '+2 = +5-3': 'handleBro',
            '+3 = +5-2': 'handleBro',
            '+4 = +5-1': 'handleBro',
            '+1 = -9+10': 'handleMate',
            '+2 = -8+10': 'handleMate',
            '+3 = -7+10': 'handleMate',
            '+4 = -6+10': 'handleMate',
            '+5 = -5+10': 'handleMate',
            '+9 = -1+10': 'handleMate',
            '+8 = -2+10': 'handleMate',
            '+7 = -3+10': 'handleMate',
            '+6 = -4+10': 'handleMate'
        };
    }

    return map[formula];
}

function getMateBeforeForRequiredFormula(rule, len, starter, taboo) {
    const nums = _.range(-9, 10); // [-9, 8]
    const ruleTarget = {
        '-1': 0,
        '1': 9
    };
    const oneBeforeLastMin = {
        '-1': 9,
        '-2': 8,
        '-3': 7,
        '-4': 6,
        '-5': 5,
        '-6': 4,
        '-7': 3,
        '-8': 2,
        '-9': 1
    };

    const getSums = (list, next, i) => {
        const prevSum = _.last(list);
        const isLastIteration = i === len - 1;
        const isPenultimateIteration = i === len - 2;

        let candidates =
            rule > 0
                ? nums.map(v => _.add(prevSum, v)).filter(v => v > 0)
                : nums
                    .map(v => _.add(prevSum, v))
                    .filter(v =>
                        isPenultimateIteration ? v >= oneBeforeLastMin[rule] : v > 0
                    );

        candidates = _.filter(candidates, v => {
            if (v === prevSum) return false;
            // if (len > 2 && v === _.nth(list, -2)) return false;
            if (
                _.includes(taboo, _.subtract(v, prevSum)) &&
                !_.isEqual(_.floor(prevSum, -1), _.floor(v, -1))
            )
                return false;
            return v;
        });

        let picked;

        if (rule in ruleTarget && !isLastIteration) {
            candidates = candidates.filter(v => getLastDigit(v) !== ruleTarget[rule]);

            if (rule === -1 && !isPenultimateIteration) {
                candidates = candidates.filter(v => getLastDigit(v) !== 9);
            }
        }

        if (isLastIteration) {
            candidates = candidates.filter(v => {
                const diff = v + rule;
                return diff > 0 && !_.isEqual(_.floor(v, -1), _.floor(diff, -1));
            });

            picked = _.sample(candidates);
        } else {
            picked = _.sample(candidates);
        }

        return list.concat(picked);
    };

    const sums = _.range(len).reduce(getSums, [starter]);

    const chunk = [];

    sums.reduce((prev, next) => {
        chunk.push(next - prev);
        return next;
    });

    return chunk;
}

function getBroBeforeForRequiredFormula(rule, len, starter, taboo) {
    const ruleTarget = {
        '1': [4],
        '-1': [5],
        '2': [3, 4],
        '-2': [5, 6],
        '3': [2, 3, 4],
        '-3': [5, 6, 7],
        '4': [1, 2, 3, 4],
        '-4': [5, 6, 7, 8]
    };

    const ruleExeptions = {
        '1': { 4: [5, 6, 7, 8] },
        '-1': { 5: [1, 2, 3] },
        '2': { 3: [5, 6, 7], 4: [6, 7, 8] },
        '-2': { 5: [1, 2], 6: [2, 3] },
        '3': { 2: [5, 6], 3: [6, 7], 4: [7, 8] },
        '-3': { 5: [1], 6: [2], 7: [3] },
        '4': { 1: [5], 2: [6], 3: [7], 4: [8] },
        '-4': { 5: [], 6: [], 7: [], 8: [] }
    };

    const theChoosenOne = _.sample(ruleTarget[rule]);
    const theChoosenOneExeptions = ruleExeptions[rule][theChoosenOne];

    const getSums = (list, next, i) => {
        const nums = _.range(-9, 10); // [-9, 9]
        const prevSum = _.last(list);
        const isLastIteration = i === len - 1;
        const isPenultimateIteration = i === len - 2;

        let candidates = nums.map(v => _.add(prevSum, v)).filter(v => v > 0);

        candidates = candidates.filter(v => {
            // суммы этажей не должны совпадать
            if (v === prevSum) return false;

            // if (len > 2 && v === _.nth(list, -2)) return false;

            const diff = v - prevSum;

            if (!_.isEqual(_.floor(v, -1), _.floor(prevSum, -1))) return false;

            if (_.includes(taboo, diff)) {
                const vLastD = getLastDigit(v);
                const prevSumLastD = getLastDigit(prevSum);

                if (diff > 0) {
                    if (prevSumLastD < 5 && vLastD >= 5) return false; // выполнилось плюсовое правило из табу
                } else {
                    if (vLastD < 5 && prevSumLastD >= 5) return false; // выполнилось минусовое правило из табу
                }

                return v;
            }

            return v;
        });

        let picked;

        if (isLastIteration) {
            // const actualSums = candidates.filter(v => {
            // 	const vLastD = getLastDigit(v);
            // 	const vSumLastD = getLastDigit(v + rule);

            // 	if (rule > 0) {
            // 		if (vLastD < 5 && vSumLastD >= 5) return v;
            // 	} else {
            // 		if (vSumLastD < 5 && vLastD >= 5) return v;
            // 	}

            // 	return false;
            // });

            // picked = _.sample(actualSums);

            picked = theChoosenOne;
        } else {
            candidates = candidates.filter(v => getLastDigit(v) !== theChoosenOne);

            if (isPenultimateIteration) {
                // на предпоследней итерации
                candidates = candidates.filter(
                    v => theChoosenOneExeptions.indexOf(getLastDigit(v)) === -1
                );
                picked = _.sample(candidates);
            } else {
                picked = _.sample(candidates);
            }
        }

        return list.concat(picked);
    };

    const sums = _.range(len).reduce(getSums, [starter]);

    const chunk = [];

    sums.reduce((prev, next) => {
        chunk.push(next - prev);
        return next;
    });

    return chunk;
}

function getTailColumn(
    // rule,
    len,
    starter,
    taboo,
    operations,
    isDirect4
    // options
) {
    // const nums = _.range(-9, 10); // [-9, 9]
    // const lastPlusIndex = _.lastIndexOf(operations, '+')
    // const penultimatePlusIndex = _.lastIndexOf(_.slice(operations, 0, lastPlusIndex), '+')
    // const isLastIterationMinusIteration = lastPlusIndex !== _.findLastIndex(operations)
    // const penultimateIterationMinSum = {"-1": 4, "-2": 3, "-3": 2, "-4": 1};

    const sums = _.range(len).reduce(getSums, [starter]);

    function getSums(list, next, i) {
        const nums = _.range(-9, 10); // [-9, 9]
        const prevSum = _.last(list);
        // const isLastIteration = i === len - 1;
        // const isPenultimateIteration = i === len - 2;

        let picked;
        let candidates = nums
            .map(v => _.add(prevSum, v))
            .filter(v => v >= 0)
            .filter(v => (operations[i] === '-' ? v <= prevSum : v >= prevSum));

        // if(i >= penultimatePlusIndex) {        // 	candidates = _.filter(candidates, v => v >= penultimateIterationMinSum[rule]) // если прошли предпоследний плюс, то сумма шага больше не опускается ниже минимальной
        // }

        if(isDirect4) {
            candidates = candidates.filter(v => v <= 4);
        }

        candidates = candidates.filter(v => {
            // if (v === prevSum) return false;
            // if (len > 2 && v === _.nth(list, -2)) return false;

            const diff = v - prevSum;

            if (_.floor(v, -1) !== _.floor(prevSum, -1)) return false;

            if (_.includes(taboo, diff)) {
                const vLastD = getLastDigit(v);
                const prevSumLastD = getLastDigit(prevSum);

                if (diff > 0) {
                    if (prevSumLastD < 5 && vLastD >= 5) return false; // выполнилось плюсовое правило из табу
                } else {
                    if (vLastD < 5 && prevSumLastD >= 5) return false; // выполнилось минусовое правило из табу
                }

                return v >= 0;
            }

            return v >= 0;
        });

        // if(!rule) {
        // 	return list.concat(_.sample(candidates));
        // }

        // if(i >= lastPlusIndex) { // как дошли до последнего плюса выбираем уже исключительно среди кандидатов ибо впереди могут быть только минусы
        // 	const actualSums = candidates.filter(v => {
        // 		const vLastD = getLastDigit(v)
        // 		const vSumLastD = getLastDigit(v + rule)

        // 		if(rule > 0) {
        // 				if(vLastD < 5 && vSumLastD >= 5) return v;
        // 		} else {
        // 				if(vSumLastD < 5 && vLastD >= 5) return v;
        // 		}

        // 		return false;
        // 	});

        // 	picked = _.sample(actualSums);
        // } else {
        // 	picked = _.sample(candidates);
        // }

        picked = _.sample(candidates);



        return list.concat(picked);
    }

    const chunk = [];

    sums.reduce((prev, next) => {
        chunk.push(next - prev);
        return next;
    });

    return chunk;
}

function getLastDigit(n) {
    return parseInt(_.last(n.toString()), 10);
}

function getOperationsMap(column) {
    return column.map(n => (n > 0 ? '+' : '-'));
}

function plusRulesOnly(formulas) {
    return formulas.filter(f => parseInt(f, 10) > 0);
}

function concatColumns(prev, cur) {
    return _.zipWith(
        prev,
        cur,
        (a, b) => String(Math.abs(a)) + String(Math.abs(b))
    );
}

export const generateTasks = function (data) {

    const options = {
        min: 1,
        max: 9,
        level: data.level,
        requiredFormulas: JSON.parse(data.req_formulas),
        minmax: data.minmax,
        subtraction: !!parseInt(data.subtraction),
        quantity: parseInt(data.quantity),
        nums: parseInt(data.nums)
    }

    const gen = new Generator(options)
    const tasks = gen.generateTasks()

    return tasks;
}

export function generateNumbers(data) {
    const map = {
        'от 1 до 9': { min: 1, max: 9 },
        'от 1 до 99': { min: 1, max: 99 },
        'от 1 до 999': { min: 1, max: 999 },
        'от 10 до 99': { min: 10, max: 99 },
        'от 100 до 999': { min: 100, max: 999 },
    }

    const args = map[data.minmax]
    const numbers = Array(parseInt(data.quantity)).fill().map(() => _.random(args.min, args.max))

    return numbers
}

export default {
    getLens,
    getBroAfter,
    getMateAfter,
    getChunkSimple,
    getPlusMateAfter,
    getDirectCount,
    getChildDirectCount,
    getDirectCountWithSubtraction,
    getChildDirectCountWithSubtraction,
    getRequiredFormulaHandler,
    getBroBeforeForRequiredFormula,
    getMateBeforeForRequiredFormula,
    getTailColumn,
    getOperationsMap,
    plusRulesOnly,
    concatColumns,
};
