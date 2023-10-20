<template>
    <AppLayout>

        <div class="grid p-fluid">

            <div>
                <button @click="iniciarPago">Pagar con PayPal</button>
            </div>

        </div>
    </AppLayout>
</template>



<script setup>
import { ref, watch, computed, onMounted } from 'vue';
import { useLayout } from '@/layout/composables/layout';
import { FilterMatchMode } from 'primevue/api';
import AppLayout from '../layout/AppLayout.vue';
import axios from 'axios';

function iniciarPago(){
    // Llamar a la API de Laravel para iniciar el proceso de pago
  axios.post('/crear-pedido')
    .then((response) => {
      // Redireccionar al usuario a la página de PayPal
      console.log('Resultado de la llamada', response)
      window.location.href = response.data
    })
    .catch((error) => {
      console.error('Error al iniciar el proceso de pago:', error);
    });
}

</script>

<style lang="css">
.chart-container {
    position: relative;
    margin: auto;
    height: 20vh;
    width: 20vw;
}
</style>