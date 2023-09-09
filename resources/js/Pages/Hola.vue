<template>
    <AppLayout>

        <div class="grid p-fluid">



        </div>
    </AppLayout>


</template>



<script setup>
import { ref, watch, computed, onMounted } from 'vue';
import { useLayout } from '@/layout/composables/layout';
import { FilterMatchMode } from 'primevue/api';
import AppLayout from '../layout/AppLayout.vue';
import axios from 'axios';

</script>

<style lang="css">
.chart-container {
    position: relative;
    margin: auto;
    height: 20vh;
    width: 20vw;
}
</style>