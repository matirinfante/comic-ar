<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import BigLogo from '@/Components/BigLogo.vue';
import Footer from '../Components/Footer.vue';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>



<template>

    <Head title="Política de privacidad" />

    <div class="flex items-top justify-center min-h-screen bg-[#f3f4f6]">

        <!-- contenido -->

        <!-- enlaces según login -->
        <div v-if="canLogin" class="absolute px-6 py-4 sm:block">
            <Link v-if="$page.props.user" :href="route('dashboard')" class="text-sm text-gray-900 underline">
            Ingresar al sitio</Link>

            <template v-else>
                <div class="flex justify-between mx-10">
                    <Link :href="route('login')" class="text-sm text-gray-900 underline">
                    Iniciar Sesión</Link>

                    <Link v-if="canRegister" :href="route('register')" class="text-sm ml-6 text-gray-900 underline">
                    Registrarse</Link>
                </div>
            </template>
        </div>

        <!-- información -->
        <div class="mt-16 mb-16">
            <BigLogo />
            <div class="text-5xl mt-10 text-center">
                <h2>Política de privacidad</h2>
            </div>
            <div class="text-2xl text-gray-500 mt-4 text-center">
                <h2>¡Gracias por usar ComicAR!</h2>
            </div>
            <div class="text-xl mt-4 w-3/4 md:w-1/2 mx-auto">
                <p>Nuestra misión es ayudarte a organizar tu colección de cómics, por ejemplo, permitiéndote llevar un registro de los cómics que tienes y los que te faltan y notificándote cuando salen nuevos cómics que coleccionas.</p>
            </div>
            <div class="text-xl mt-4 w-3/4 md:w-1/2 mx-auto">
                <p>Hemos escrito esta política de privacidad para ayudarte a entender qué información recolectamos, cómo la usamos y qué derechos tienes tú sobre esta información.</p>
            </div>

            <div class="text-3xl mt-10 w-3/4 md:w-1/2 mx-auto text-gray-600">
                <h2>1 ¿Quién es el responsable de tus datos?</h2>
            </div>
            <div class="text-xl mt-4 w-3/4 md:w-1/2 mx-auto">
                <p>El equipo de ComicAR 😅</p>
                <p>Pero puedes quedarte tranquilo, solo sómos estudiantes tratando de aprobar un proyecto.</p>
            </div>

            <div class="text-3xl mt-10 w-3/4 md:w-1/2 mx-auto text-gray-600">
                <h2>2 ¿Qué datos recopilamos y para qué los usamos?</h2>
            </div>
            <div class="text-xl mt-4 w-3/4 md:w-1/2 mx-auto">
                <p>Requerimos cierta información para prestarte nuestros servicios. Por ejemplo, debes tener una cuenta para añadir un cómic a tu comicteca o dejar un comentario en ComicAR. Cuando optas por compartir la siguiente información con nosotros, la recopilamos y utilizamos para administrar y mejorar nuestros servicios.</p>
            </div>

            <div class="text-3xl mt-10 w-3/4 md:w-1/2 mx-auto text-gray-400">
                <h2>2.1 Información básica de la cuenta</h2>
            </div>
            <div class="text-xl mt-4 w-3/4 md:w-1/2 mx-auto">
                <p>Si optas por crear una cuenta en ComicAR, nos proporcionas voluntariamente información personal como tu nombre, nombre de usuario, contraseña y foto de perfil. Usamos esta información para identificarte cuando uses ComicAR y poder guardar tus acciones, como si añades un cómic a tu comicteca o a tu lista de deseos, si creas contenido, etc.</p>
            </div>

            <div class="text-3xl mt-10 w-3/4 md:w-1/2 mx-auto text-gray-400">
                <h2>2.2 Información de contacto</h2>
            </div>
            <div class="text-xl mt-4 w-3/4 md:w-1/2 mx-auto">
                <p>Podemos utilizar tu información de contacto, es decir tu correo electrónico, para enviarte información sobre nuevos tomos que se añadan a una edición a la cual estás suscripto.</p>
            </div>

            <div class="text-3xl mt-10 w-3/4 md:w-1/2 mx-auto text-gray-600">
                <h2>3 Cómo y con quién compartimos tus datos</h2>
            </div>
            <div class="text-xl mt-4 w-3/4 md:w-1/2 mx-auto">
                <p>En ComicAR nos importa tu privacidad, y por ello no comerciamos con tus datos.</p>
            </div>

            <div class="text-3xl mt-10 w-3/4 md:w-1/2 mx-auto text-gray-600">
                <h2>4 Nuestra política sobre privacidad de información en menores</h2>
            </div>
            <div class="text-xl mt-4 w-3/4 md:w-1/2 mx-auto">
                <p>Nuestros servicios no están dirigidos a menores y no puedes utilizar ComicAR si tienes menos de 16 años.</p>
            </div>
            
            <div class="text-3xl mt-10 w-3/4 md:w-1/2 mx-auto text-gray-600">
                <h2>5 Cambios en esta Política de Privacidad</h2>
            </div>
            <div class="text-xl mt-4 w-3/4 md:w-1/2 mx-auto">
                <p>Podemos cambiar esta Política de Privacidad de vez en cuando. La versión más reciente de la Política regulará nuestro uso de tu información y estará siempre disponible en esta página. Si continúas usando ComicAR después de la entrada en vigor de los cambios entenderemos que estás de acuerdo con la nueva política.</p>
            </div>

        </div>

    </div>

    <Footer />
</template>