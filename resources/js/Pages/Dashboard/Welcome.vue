<template>
    <div>
        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
            <div>
                <jet-application-logo class="block h-12 w-auto" />
            </div>

            <div class="mt-8 text-2xl">
                ¡Bienvenido a tu administrador de Ventas!
            </div>

            <div class="mt-6 text-gray-500">
                En este sistema de administración podrás llevar la información de los vendedores, los clientes, el conteo de las boletas vendidas, el recaudo del dinero, así como estadísticas financieras.
            </div>
        </div>
    </div>
</template>

<script>
    import JetApplicationLogo from '@/Jetstream/ApplicationLogo.vue'

    export default {
        components: {
            JetApplicationLogo,
        },
    }
</script>