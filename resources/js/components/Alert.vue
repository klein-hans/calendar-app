<template>
  <div v-if="isSaved" class="alert alert-success alert-dismissible fade show col-lg-4 mb-2" role="alert">
    <i class="icon fa fa-check fa-fw" aria-hidden="true"></i>
    {{ message }}
    <button type="button" class="close" @click="isSaved = false" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
</div>
</template>

<script>
export default {
    props: {
        message: String,
        isSaved: Boolean
    },
}
</script>

<style>

</style>