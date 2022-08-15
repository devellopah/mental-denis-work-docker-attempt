import './bootstrap';
import './generic';

import TrainerTask from './components/TrainerTask.vue';
import RombTrainer from './components/RombTrainer.vue';

import StudentTask from './components/StudentTask.vue';
import GroupTask from './components/GroupTask.vue';

import Generator from './components/Generator.vue';
import Tasks from './components/Tasks.vue';

import vSelect from 'vue-select'
import VueNumberInput from '@chenfengyuan/vue-number-input';
import VModal from 'vue-js-modal'


Vue.use(VModal, { componentName: "v-modal" });

Vue.component('v-select', vSelect);
Vue.component(VueNumberInput.name, VueNumberInput);
Vue.component('tasks', Tasks);

new Vue({
    el: '#app',
    components: { Tasks, StudentTask, GroupTask, TrainerTask, RombTrainer, Generator }
});
