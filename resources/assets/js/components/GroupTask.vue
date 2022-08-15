<template>

<div>
    <TrainerTaskNew 
        :homeTask="JSON.parse(decodeURIComponent(task))"
        :trainer_id="trainer_id"
        :trainer_name="trainer_name"
        :student_id="student_id"
        :task_type="task_type"
        v-if="trainer_id == 1"
    ></TrainerTaskNew>
    <RombTrainerNew 
        :homeTask="JSON.parse(decodeURIComponent(task))" 
        :trainer_id="trainer_id"
        :trainer_name="trainer_name"
        :student_id="student_id"
        :task_type="task_type"
        v-else
    ></RombTrainerNew>
</div>
</template>

<script>

import TrainerTaskNew from './TrainerTaskNew';
import RombTrainerNew from './RombTrainerNew';

export default {
    name: 'GroupTask',
    components: { TrainerTaskNew, RombTrainerNew },
    props: ['task', 'trainer_name', 'trainer_id', 'student_id', 'task_type'],
    data: () => ({}),
    mounted() {},
    methods: {},
}
</script>

<style lang="scss">

</style>
