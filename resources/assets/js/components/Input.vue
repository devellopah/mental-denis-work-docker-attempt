<template>
<div class="form-group clearfix">
    <label :for="name" class="col-md-6">{{ label }}</label>


    <div class="col-md-6" v-if="type === 'text'">
        <input class="form-control" :name="name" :type="type" :id="name" v-model="model">
    </div>

    <div class="col-md-6" v-else>
        <label class="checkbox">
            <input :name="name" :type="type" :id="name">
            <span class="checkbox-material">
                <span class="check"></span>
            </span>
        </label>
    </div>
</div>
</template>

<script>
export default {
    name: 'Input',
    props: ['name', 'label', 'type', 'model']
}
</script>
