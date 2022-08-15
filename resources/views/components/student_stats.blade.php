<main class="pdg groups" id="app">
    <div class="container">
        <div class="block-bg">
            <div class="acc__top">
                <div class="acc__top-left">
                    <div class="acc__points">
                        Статистика
                    </div>
                </div>
            </div>
            <div class="users-table users-table--mrg">
                <div class="row">
                    <div class="col l4 m6 s12">
                        <label>
                            <select name="stat_id" class="js-select groups_select" style="width: 100%;">
                                <option value="all" selected>Общая</option>
                                <option value="numbers">Ментальный счёт</option>
                                <option value="rombs">Флеш-карты</option>
                            </select>
                        </label>
                    </div>
                </div>
                <div id="all" class="tab-pane active">
                    <table class="table table-striped valign-middle">
                        <thead>
                        <tr>
                            <th class="text-left">кол-во ответов</th>
                            <th class="text-left">верные ответы</th>
                            <th class="text-left">неверные ответы</th>
                            <th class="text-left">успеваемость</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="text-left">{{ $student['all']['answers_total'] }}</td>
                            <td class="text-left">{{ $student['all']['answers_correct'] }}</td>
                            <td class="text-left">{{ $student['all']['answers_wrong'] }}</td>
                            <td class="text-left">{{ $student['all']['answers_accuracy'] }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div id="numbers" class="tab-pane">
                    <table class="table table-striped valign-middle">
                        <thead>
                        <tr>
                            <th class="text-left">кол-во ответов</th>
                            <th class="text-left">верные ответы</th>
                            <th class="text-left">неверные ответы</th>
                            <th class="text-left">успеваемость</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="text-left">{{ $student['numbers']['answers_total'] }}</td>
                            <td class="text-left">{{ $student['numbers']['answers_correct'] }}</td>
                            <td class="text-left">{{ $student['numbers']['answers_wrong'] }}</td>
                            <td class="text-left">{{ $student['numbers']['answers_accuracy'] }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div id="rombs" class="tab-pane">
                    <table class="table table-striped valign-middle">
                        <thead>
                        <tr>
                            <th class="text-left">кол-во ответов</th>
                            <th class="text-left">верные ответы</th>
                            <th class="text-left">неверные ответы</th>
                            <th class="text-left">успеваемость</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="text-left">{{ $student['rombs']['answers_total'] }}</td>
                            <td class="text-left">{{ $student['rombs']['answers_correct'] }}</td>
                            <td class="text-left">{{ $student['rombs']['answers_wrong'] }}</td>
                            <td class="text-left">{{ $student['rombs']['answers_accuracy'] }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

