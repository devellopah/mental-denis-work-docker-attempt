<template>

    <div class="View">
        <div class="View__head">

            <div class="container">
                <div class="row text-center">

                    <div class="col-sm-5 text-sm-left">
                        <h2 class="View__title mb-sm-0">
                            Параметры заданий
                        </h2>
                    </div>

                    <div class="col-sm-7 text-sm-right">
                        <div class="View__headActions">
                        <a class="View__createCat" href="#" id="show-modal" @click="showModal">Добавить настройки</a>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <div class="View__body">

            <div class="container">
                <div class="row">

                    <div class="col-sm-4 col-md-3" style="padding-bottom: 40px;">
                        <ul class="nav nav-tabs">
                            <li class="active"><a ref="group" data-toggle="tab" href="#group" class="stats-header">Общие</a></li>
                            <li><a ref="student" data-toggle="tab" href="#student" class="stats-header">Индивидуальные</a></li>
                        </ul>
                    </div>

                    <div class="col-sm-8 col-md-9">

                        <div class="tab-content" style="flex-grow: 1;">
                            <div id="group" class="tab-pane fade in active">
                                <div class="table-overflow container-fluid">
                                    <table ref="groupTasksTable" class="table table-striped valign-middle js-task-table">
                                        <thead>
                                        <tr>
                                            <th class="text-left">Тренажёр</th>
                                            <th class="text-left">Параметры</th>
                                            <th class="text-left">Выполнение</th>
                                            <th class="text-left">Удалить</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <tr valign="middle" class="" v-for="task in group_tasks" :key="task.id">
                                                <td class="text-left">{{ task.trainer_name }}</td>
                                                <td class="text-left" v-if="JSON.parse(task.req_formulas)">
                                                    <p><span>Уровень</span> - <span>{{ task.level }}</span></p>
                                                    <p><span>Слагаемых</span> - <span>{{ task.nums }}</span></p>
                                                    <p><span>Примеров</span> - <span>{{ task.quantity }}</span></p>
                                                    <p v-if="!JSON.parse(task.req_formulas).length"><span>Обяз. формулы</span> - <span>нет</span></p>
                                                    <p v-else><span>Обяз. формулы : </span>
                                                        <strong v-for="(formula, i) in JSON.parse(task.req_formulas)" :key="i">{{ formula }}</strong>
                                                    </p>
                                                    <p><span>Вычитание</span> - <span>{{ task.subtraction ? 'да' : 'нет' }}</span></p>
                                                </td>
                                                <td class="text-left" v-else>
                                                    <p>Диапазон - {{ task.minmax }}</p>
                                                    <p>Кол-во чисел - {{ task.quantity }}</p>
                                                </td>
                                                <td class=""><a :href="getRoute(['group.task.statistics', groupId, task.id])" style="text-decoration: underline;color: #2196F3;">Смотреть</a></td>
                                                <td class="text-center">
                                                    <a href="#" @click.prevent="removeTask(task.id, 'group')"><i class="far fa-trash-alt"></i></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div id="student" class="tab-pane fade">
                                <div class="table-overflow container-fluid">
                                    <table class="table table-striped valign-middle js-task-table">
                                        <thead>
                                        <tr>
                                            <th class="text-left">Тренажёр</th>
                                            <th class="text-left">Исполнитель</th>
                                            <th class="text-left">Параметры</th>
                                            <th class="text-left">Выполнение</th>
                                            <th class="text-left">Удалить</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <tr valign="middle" v-for="task in student_tasks" :key="task.id">
                                                <td class="text-left">{{ task.trainer_name }}</td>
                                                <td class="text-left">{{ task.student }}</td>
                                                <td class="text-left" v-if="JSON.parse(task.req_formulas)">
                                                    <p><span>Уровень</span> - <span>{{ task.level }}</span></p>
                                                    <p><span>Слагаемых</span> - <span>{{ task.nums }}</span></p>
                                                    <p><span>Примеров</span> - <span>{{ task.quantity }}</span></p>
                                                    <p v-if="!JSON.parse(task.req_formulas).length"><span>Обяз. формулы</span> - <span>нет</span></p>
                                                    <p v-else><span>Обяз. формулы : </span>
                                                        <strong v-for="(formula, i) in JSON.parse(task.req_formulas)" :key="i">{{ formula }}</strong>
                                                    </p>
                                                    <p><span>Вычитание</span> - <span>{{ task.subtraction ? 'да' : 'нет' }}</span></p>
                                                </td>
                                                <td class="text-left" v-else>
                                                    <p>Диапазон - {{ task.minmax }}</p>
                                                    <p>Кол-во чисел - {{ task.quantity }}</p>
                                                </td>
                                                <td class="text-left" v-if="task.is_finished">
                                                    <p>Старт - {{task.started_time}}</p>
                                                    <p>Время выполнения - {{task.lead_time}}</p>
                                                    <p>Успеваемость - {{task.accuracy}}</p>
                                                </td>
                                                <td class="text-left" v-else>
                                                    В процессе
                                                </td>
                                                <td class="text-center">
                                                    <a href="#" @click.prevent="removeTask(task.id, 'student')"><i class="far fa-trash-alt"></i></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <v-modal
                    name="settings"
                    height="auto"
                    :adaptive="true"
                    :scrollable="true"
                    :width="800"
                >

                    <div style="padding: 15px; margin: auto;">
                        <h3>Задать ДЗ</h3>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="row form-group clearfix">
                                    <div class="col-md-12">
                                        <label for="trainer_id" class="">Тренажёр</label>
                                    </div>
                                    <div class="col-md-12">
                                        <v-select
                                            v-model="options.trainer"
                                            :searchable="false"
                                            :clearable="false"
                                            :options="trainers"
                                            :reduce="trainer => trainer.id"
                                            label="name"
                                        ></v-select>
                                    </div>
                                </div>
                                <!-- Скорость -->
                                <div class="row form-group clearfix">
                                    <div class="col-md-12">
                                        <label for="trainer_id" class="">Скорость</label>
                                    </div>
                                    <div class="col-md-12" v-if="!options.isHighSpeed">
                                        <number-input
                                            v-model="options.speed"
                                            :min="1"
                                            :max="10"
                                        ></number-input>
                                    </div>
                                    <div class="col-md-12" v-else>
                                        <number-input
                                            v-model="options.speed"
                                            :min="0.1"
                                            :max="1"
                                            :step="0.1"
                                        ></number-input>
                                    </div>
                                </div>
                                <div class="row form-group clearfix">
                                    <div class="col-md-12" v-if="options.individual">
                                        <label for="trainer_id" class="">Выберите студента</label>
                                    </div>
                                    <div class="col-md-12" v-if="options.individual">
                                        <v-select
                                            v-model="options.student"
                                            :searchable="false"
                                            :clearable="false"
                                            :options="students"
                                            :reduce="student => student.id" 
                                            label="username"
                                        ></v-select>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="checkbox" style="padding: 0;">
                                            <input
                                                type="checkbox"
                                                v-model="options.individual"
                                            />
                                            <span class="checkbox-material">
                                            <span class="check"></span>
                                            </span>
                                            Индивидуальное задание
                                        </label>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="checkbox" style="padding: 0;">
                                            <input
                                                type="checkbox"
                                                v-model="options.isHighSpeed"
                                            />
                                            <span class="checkbox-material">
                                            <span class="check"></span>
                                            </span>
                                            Скорость профессионалов
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6" v-if="options.trainer.id === 1">
                                <!-- Уровень -->
                                <div class="row form-group clearfix">
                                    <div class="col-md-12">
                                    <label for="rules" class="">Уровень</label>
                                    </div>

                                    <div class="col-md-12">
                                    <v-select
                                        v-model="options.level"
                                        :searchable="false"
                                        :clearable="false"
                                        :options="rules"
                                        inputId="rules"
                                    ></v-select>
                                    </div>
                                </div>

                                <!-- Обяз. формулы -->
                                <div class="row form-group clearfix">
                                    <div class="col-md-12">
                                    <label for="requiredFormulas" class="">Обяз. формулы</label>
                                    </div>

                                    <div class="col-md-12">
                                    <v-select
                                        multiple
                                        v-model="options.requiredFormulas"
                                        :options="formulas"
                                        inputId="requiredFormulas"
                                        :disabled="!formulas.length"
                                    ></v-select>
                                    </div>
                                </div>
                                <!-- Размер слагаемого -->
                                <div class="row form-group clearfix">
                                    <div class="col-md-12">
                                    <label for="minmax" class="">Размер слагаемого</label>
                                    </div>

                                    <div class="col-md-12">
                                    <v-select
                                        v-model="options.minmax"
                                        :searchable="false"
                                        :clearable="false"
                                        :options="options.level === 'прямой счёт к 4' ? direct4minmax: minmax"
                                        inputId="minmax"
                                    ></v-select>
                                    </div>
                                </div>

                                <!-- Кол-во примеров -->
                                <div class="row form-group clearfix">
                                    <div class="col-md-12">
                                    <label for="quantity" class="">Кол-во примеров</label>
                                    </div>

                                    <div class="col-md-12">
                                    <number-input
                                        v-model="options.quantity"
                                        id="quantity"
                                        :min="1"
                                    ></number-input>
                                    </div>
                                </div>

                                <!-- Кол-во чисел в примере -->
                                <div class="row form-group clearfix">
                                    <div class="col-md-12">
                                    <label for="nums" class="">Кол-во слагаемых</label>
                                    </div>

                                    <div class="col-md-12">
                                    <number-input
                                        v-model="options.nums"
                                        id="nums"
                                        :min="1"
                                        :max="maxTaskLen"
                                    ></number-input>
                                    </div>
                                </div>

                                <!-- Вычитание -->
                                <div class="row form-group clearfix" style="display: flex; align-items: center;">
                                    <label class="col-md-12" style="margin-bottom: 0;">Вычитание</label>
                                    <div class="col-md-12">
                                    <label class="checkbox" style="padding: 0;">
                                        <input
                                        type="checkbox"
                                        v-model="options.subtraction"
                                        :disabled="subtractionNotToggleable"
                                        />
                                        <span class="checkbox-material">
                                        <span class="check"></span>
                                        </span>
                                    </label>
                                    </div>
                                </div>

                            </div>

                            <div class="col-sm-6" v-else>
                                <!-- Размер слагаемого -->
                                <div class="row form-group clearfix">
                                    <div class="col-md-12">
                                    <label for="minmax" class="">Размер числа</label>
                                    </div>

                                    <div class="col-md-12">
                                    <v-select
                                        v-model="options.minmax"
                                        :searchable="false"
                                        :clearable="false"
                                        :options="options.level === 'прямой счёт к 4' ? direct4minmax: minmax"
                                        inputId="minmax"
                                    ></v-select>
                                    </div>
                                </div>

                                <!-- Кол-во примеров -->
                                <div class="row form-group clearfix">
                                    <div class="col-md-12">
                                    <label for="quantity" class="">Кол-во чисел</label>
                                    </div>

                                    <div class="col-md-12">
                                    <number-input
                                        v-model="options.quantity"
                                        id="quantity"
                                        :min="1"
                                    ></number-input>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <button class="btn" @click="hideModal">Закрыть</button>
                                <button class="btn btn-success" @click.prevent="createTaskSettings">Применить</button>
                            </div>
                        </div>
                    </div>
                    <div>
                    </div>

                </v-modal>

            </div>

        </div>
    </div>

</template>

<script>
import _ from 'lodash'
import * as DATA from '../data'
import FORMULASMAP from '../formulas'

// import { route } from '../helpers'


export default {
    name: 'Tasks',
    components: {},
    props: ['groupId'],
    data: () => ({
        options: {
            min: 1,
            max: 9,
            level: '+1 = +5-4',
            requiredFormulas: [],
            minmax: 'от 1 до 9',
            subtraction: true,
            quantity: 10,
            nums: 4,
            trainer: {id: 1, name: 'Ментальный счёт'},
            student: null,
            individual: false,
            speed: 1,
            isHighSpeed: false,
        },
        formulas: FORMULASMAP['+1 = +5-4'],
        rules: DATA.rules,
        minmax: DATA.minmax,
        direct4minmax: DATA.direct4minmax,
        trainers: [{id: 1, name: 'Ментальный счёт'}, {id: 2, name: 'Флеш-карты'}],
        students: [],
        group_tasks: [],
        student_tasks: [],
    }),
    computed: {
        rule() {
        const rule = parseInt(this.options.level, 10);
        return Number.isNaN(rule) ? true : rule;
        },
        level() {
        return DATA.levels[this.options.level];
        },
        minTaskLen() {
        return this.level === 'mate' && this.rule < 0 ? 3 : 2;
        },
        maxTaskLen() {
        if (this.options.subtraction) return 10;

        if (this.level === 'direct') {
            if (this.options.level === 'прямой счёт к 4') return 4;
            return 5;
        }

        if (this.level === 'bro' && this.rule > 0) {
            if (this.options.requiredFormulas.length === 1) {
                const requiredRule = parseInt(this.options.requiredFormulas[0], 10);
                if (requiredRule === 1) return 9;
                if (requiredRule === 2) return 8;
                if (requiredRule === 3) return 7;
                if (requiredRule === 4) return 6;
                }

                if (this.rule === 1) return 9;
                if (this.rule === 2) return 8;
                if (this.rule === 3) return 7;
                if (this.rule === 4) return 6;
            }
        },
        subtractionNotToggleable() {
        const { requiredFormulas } = this.options;
        if (this.level === 'bro' && this.rule === 1) return true;
        if (requiredFormulas.some(f => parseInt(f, 10) < 0)) return true;
        if (
            requiredFormulas.length === 2 &&
            DATA.levels[requiredFormulas[0]] === DATA.levels[requiredFormulas[1]]
        )
            return true;
        if (requiredFormulas.length > 2) return true;

        return false;
        },

        levelTaboo() {
        return this.level === 'direct'
            ? [1, -1, 2, -2, 3, -3, 4, -4]
            : DATA[`${this.level}Taboo`][this.options.level];
        },

        ruleColumns() {
        return DATA.ruleColumns[this.options.minmax];
        },
    },

    watch: {
        min(val) {
        this.options.nums = val;
        },
        'options.isHighSpeed'(checked) {
            checked
                ? this.options.speed = 0.1
                : this.options.speed = 1
        },
        'options.level'(val) {
        this.options.nums = 4;
        this.formulas = FORMULASMAP[val];
        this.options.requiredFormulas = [];

        if (val === 'прямой счёт к 4') this.options.minmax = 'от 1 до 4';
        if (val === 'прямой счёт к 9') this.options.minmax = 'от 1 до 9';

        val === 'прямой счёт к 4'
            ? (this.options.max = 4)
            : (this.options.max = 9);
        },
        'options.requiredFormulas'(list) {
        if (!this.options.subtraction && this.options.nums > 6) {
            if (this.options.requiredFormulas.length === 1) {
            const requiredRule = parseInt(this.options.requiredFormulas[0], 10);

            if (this.isBroPositive(this.options.requiredFormulas[0])) {
                if (requiredRule === 1 && this.options.nums > 9)
                this.options.nums = 9;
                if (requiredRule === 2 && this.options.nums > 8)
                this.options.nums = 8;
                if (requiredRule === 3 && this.options.nums > 7)
                this.options.nums = 7;
                if (requiredRule === 4 && this.options.nums > 6)
                this.options.nums = 6;
            }
            } else if (
            this.options.requiredFormulas.length === 0 &&
            this.level === 'bro' &&
            this.rule > 0
            ) {
            if (this.rule === 1 && this.options.nums > 9) this.options.nums = 9;
            if (this.rule === 2 && this.options.nums > 8) this.options.nums = 8;
            if (this.rule === 3 && this.options.nums > 7) this.options.nums = 7;
            if (this.rule === 4 && this.options.nums > 6) this.options.nums = 6;
            }
        }
        if (list.some(f => parseInt(f, 10) < 0)) this.options.subtraction = true;
        if (list.length > 2) this.options.subtraction = true;
        if (list.length === 2 && DATA.levels[list[0]] === DATA.levels[list[1]])
            this.options.subtraction = true;
        },

        'options.subtraction'(checked) {
            if (!checked) {
                if (this.level === 'direct') {
                this.options.nums = this.maxTaskLen;
                }
            }
            if (this.options.nums > 6) {
                if (!checked && this.level === 'bro' && this.rule > 0) {
                if (this.options.requiredFormulas.length > 0) {
                    this.options.nums = this.maxTaskLen;
                } else {
                    if (this.rule === 1 && this.options.nums > 9) this.options.nums = 9;
                    if (this.rule === 2 && this.options.nums > 8) this.options.nums = 8;
                    if (this.rule === 3 && this.options.nums > 7) this.options.nums = 7;
                    if (this.rule === 4 && this.options.nums > 6) this.options.nums = 6;
                }
                }
            }
        },

        'options.individual'(checked) {
            if(!checked) this.options.student = null;
        },
    },
    
    mounted() {
        this.task_table = $('.js-task-table')

        axios.post('/api/tasks', { group_id: this.groupId })
            .then(this.handleTasks)
            .then(this.initDataTable)
            .catch(err => window.toastr.error(err.message))
    },

    methods: {

        getRoute(args) {

            return window.route(...args)

        },
        showModal () {
            this.$modal.show('settings');
        },
        hideModal () {
            this.$modal.hide('settings');
        },

        removeTask(task_id, task_type) {

            axios.post('/api/tasks/remove_task', {
                task_type: task_type, 
                task_id: task_id, 
                group_id: parseInt(this.groupId) 
            })
            .then(this.handleTaskRemoveResponse)
            // .then(this.reloadDataTable)
            .catch(err => window.toastr.error(err.message))
        },

        handleTaskRemoveResponse(response) {
            window.toastr.success('Задание успешно удалено!');

            if(response.data.group_tasks) this.group_tasks = response.data.group_tasks
            if(response.data.student_tasks) this.student_tasks = response.data.student_tasks
        },

        handleTaskCreateResponse(response) {
            window.toastr.success('Задание успешно создано!');

            if(response.data.group_tasks) {
                this.group_tasks = response.data.group_tasks
            } else {
                this.student_tasks = response.data.student_tasks
            }
        },

        handleTasks(response) {
            this.students = response.data.students;
            this.group_tasks = response.data.group_tasks;
            this.student_tasks = response.data.student_tasks;
        },

        initDataTable() {
            this.task_table.DataTable({
                responsive: true,
                "language": {
                    "processing": "Подождите...",
                    "search": "Поиск:",
                    "lengthMenu": "Показать _MENU_ записей",
                    "info": "Записи с _START_ до _END_ из _TOTAL_ записей",
                    "infoEmpty": "Записи с 0 до 0 из 0 записей",
                    "infoFiltered": "(отфильтровано из _MAX_ записей)",
                    "infoPostFix": "",
                    "loadingRecords": "Загрузка записей...",
                    "zeroRecords": "Записи отсутствуют.",
                    "emptyTable": "В таблице отсутствуют данные",
                    "paginate": {
                        "first": "Первая",
                        "previous": "Предыдущая",
                        "next": "Следующая",
                        "last": "Последняя"
                    },
                    "aria": {
                        "sortAscending": ": активировать для сортировки столбца по возрастанию",
                        "sortDescending": ": активировать для сортировки столбца по убыванию"
                    }
                },
                "order": [[0, 'asc']]
            });
        },

        reloadDataTable() {
            this.task_table.ajax.reload()
        },
        
        createTaskSettings() {
            const { level, requiredFormulas, quantity, nums, trainer, minmax, subtraction, speed } = this.options

            const data = {
                quantity:     quantity,
                trainer_id:   trainer.id,
                trainer_name:   trainer.name,
                minmax:       minmax,
                speed:        speed,
                group_id:   parseInt(this.groupId),
            };

            // если тренажёр "ментальный счёт"
            if(trainer.id === 1) {
                data.level = level
                data.req_formulas = JSON.stringify(requiredFormulas)
                data.nums = nums
                data.subtraction = subtraction
            }

            if(this.options.individual) {
                 if(!this.options.student) {
                    alert('Выберите студента для индивидуального задания');
                    return;
                }
                data.student_id = this.options.student.id; // студен должен быть выбран
                data.student = this.options.student.username;

                this.$refs.student.click()               
            }

            this.hideModal()

            axios.post('/api/tasks/generate', data)
            .then(this.handleTaskCreateResponse)
            // .then(this.reloadDataTable)
            .catch(err => window.toastr.error(err.message))
        }
    }
}
</script>

<style lang="scss">
input.number-input__input[data-v-607416cd] {
    height: 42px;
    font-size: inherit;
}
</style>
