<template>
  <app-layout title="Usuarios">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Usuarios
      </h2>
    </template>

    <div class="grid grid-cols-8 px-4">
      <div class="relative col-span-2">
        <form
          class="sticky top-4 my-4 bg-white shadow overflow-hidden sm:rounded"
          @submit.prevent="submit"
        >
          <header class="py-3 px-2 sm:px-4">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
              Registrar Nuevo Usuario
            </h3>
          </header>

          <!-- Body -->
          <div class="border-t border-gray-200 px-4 py-6">
            <!-- Nombre del usuario -->
            <div class="mb-2">
              <custom-label for="userName" :required="true"
                >Nombre</custom-label
              >
              <custom-input
                type="text"
                name="userName"
                id="userName"
                placeholder="Escribe el nombre aquí."
                v-model.trim="form.name"
                :hasError="form.errors.name ? true : false"
                @blur="validateName"
              />

              <jet-input-error :message="form.errors.name" />
            </div>

            <!-- Email -->
            <div class="mb-2">
              <custom-label for="email" :required="true">Correo</custom-label>
              <custom-input
                type="email"
                name="email"
                id="email"
                placeholder="usuario@ejemplo.com"
                v-model.trim="form.email"
                :hasError="form.errors.email ? true : false"
                @blur="validateEmail"
              />
              <jet-input-error :message="form.errors.email" />
            </div>

            <!-- Contraseña -->
            <div class="mb-2">
              <custom-label for="user-password" :required="true"
                >Contraseña</custom-label
              >
              <custom-input
                type="password"
                name="user-password"
                id="user-password"
                v-model.trim="form.password"
                :hasError="form.errors.password ? true : false"
                @blur="validatePassword"
              />
              <jet-input-error :message="form.errors.password" />
            </div>

            <!-- Contraseña -->
            <div class="mb-2">
              <custom-label for="confirmPassword"
                >Confirmar Contraseña</custom-label
              >
              <custom-input
                type="password"
                name="confirmPassword"
                id="confirmPassword"
                v-model.trim="form.password_confirmation"
                :hasError="form.errors.password_confirmation ? true : false"
                @blur="validateConfirmPassword"
              />

              <jet-input-error :message="form.errors.password_confirmation" />
            </div>
          </div>

          <footer class="bg-gray-200 px-2 py-2">
            <jet-button :disabled="form.processing">Registrar</jet-button>
          </footer>
        </form>
      </div>

      <div class="col-span-6">
        <!--  Tabla de Usuarios -->
        <div class="flex flex-col">
          <!-- Level 1 -->
          <div class="my-2 overflow-x-auto">
            <!-- Level 2 -->
            <div
              class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8"
            >
              <!-- Level 3 -->
              <div
                class="
                  shadow
                  overflow-hidden
                  border-b border-gray-200
                  sm:rounded-lg
                "
              >
                <!-- Table -->
                <table class="min-w-full divide-y divide-gray-200">
                  <thead class="bg-gray-50">
                    <tr>
                      <!-- Nombre -->
                      <th
                        scope="col"
                        class="
                          px-6
                          py-3
                          text-left text-xs
                          font-medium
                          text-gray-500
                          uppercase
                          tracking-wider
                        "
                      >
                        Nombre
                      </th>
                      <!-- Email -->
                      <th
                        scope="col"
                        class="
                          px-6
                          py-3
                          text-left text-xs
                          font-medium
                          text-gray-500
                          uppercase
                          tracking-wider
                        "
                      >
                        Email
                      </th>
                      <!-- Actions -->
                      <th scope="col" class="relative px-6 py-3">
                        <span class="sr-only">Edit</span>
                      </th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="user in users" :key="user.id">
                      <!-- Nombre de usuario -->
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                          <!-- User Image -->
                          <div class="flex-shrink-0 h-10 w-10">
                            <img
                              :src="user.profile_photo_url"
                              alt=""
                              class=""
                            />
                          </div>
                          <!-- /.end user Image -->

                          <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">
                              {{ user.name }}
                            </div>
                            <div class="text-sm text-gray-900">
                              Administrador
                            </div>
                          </div>
                        </div>
                      </td>

                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                          {{ user.email }}
                        </div>
                      </td>

                      <td
                        class="
                          px-6
                          py-4
                          whitespace-nowrap
                          text-right text-sm
                          font-medium
                        "
                      >
                        <a href="javascript:;" @click="destroy(user.id)" class="text-red-600 hover:text-opacity-50">
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                          >
                            <path
                              fill-rule="evenodd"
                              d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                              clip-rule="evenodd"
                            />
                          </svg>
                        </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <!-- /.end table -->
              </div>
              <!-- /.end level 3 -->
            </div>
            <!-- /.end level 2 -->
          </div>
          <!-- /.end level 1 -->
        </div>
        <!-- /.end user table -->
      </div>
    </div>
  </app-layout>
</template>

<script>
import { useForm } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import { Link } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import CustomLabel from "@/Form/Label.vue";
import CustomInput from "@/Form/Input.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetInputError from "@/Jetstream/InputError";

export default {
  props: ["users", "alert"],
  components: {
    AppLayout,
    JetButton,
    CustomLabel,
    CustomInput,
    JetInputError,
    Link,
  },
  data() {
    return {
      form: new useForm({
        name: null,
        email: null,
        password: null,
        password_confirmation: null,
      }),
    };
  },
  methods: {
    validateName() {
      let value = this.form.name;
      let error = null;
      if (value && !window._.isEmpty(value)) {
        if (value.length >= 3) {
          if (value.length <= 45) {
            this.form.clearErrors("name");
            return true;
          } else {
            error = "Debe tener un máximo de 45 caracteres.";
          }
        } else {
          error = "Debe tener un minimo de 3 caracteres";
        }
      } else {
        error = "Este campo es requerido.";
      }

      this.form.errors.name = error;
      return false;
    }, //.end validateName
    validateEmail() {
      let value = this.form.email;
      let error = null;
      const mailFormat =
        /(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/;

      if (value) {
        if (value.match(mailFormat)) {
          this.form.clearErrors("email");
          return true;
        } else {
          error = "La dirección de correo es inválida.";
        }
      } else {
        error = "Este campo es requerido.";
      }

      this.form.errors.email = error;
      return false;
    },
    validatePassword() {
      let value = this.form.password;
      let error = null;

      if (value) {
        if (value.length >= 8) {
          this.form.clearErrors("password");
          return true;
        } else {
          error = "La contraseña debe tener almeno 8 caracteres.";
        }
      } else {
        error = "El campo es requerido";
      }

      this.form.errors.password = error;
      return false;
    },
    validateConfirmPassword() {
      let password = this.form.password;
      let confirm = this.form.password_confirmation;
      let error = null;

      if (password && !this.form.errors.password) {
        if (confirm) {
          if (confirm.length >= 8 && password === confirm) {
            this.form.clearErrors("password_confirmation");
            return true;
          } else {
            error = "Las contraseñas no coinciden.";
          }
        } else {
          error = "Se debe confirmar la contraseña.";
        }
      } else {
        error = "";
      }

      this.form.errors.password_confirmation = error;
      return false;
    },
    validateSubmit() {
      let results = [
        this.validateName(),
        this.validateEmail(),
        this.validatePassword(),
        this.validateConfirmPassword(),
      ];

      return !results.some((res) => res === false);
    },
    submit() {
      //Se valida que los datos estén bien
      if (this.validateSubmit()) {
        //Se recupera la url donde se va a enviar el formulario
        let url = this.route("users.store");
        //Se envía el formulario con Inertia
        this.form.post(url, {
          //Se previene que el scroll se mueva
          preserveScroll: true,
          //Sei todo fue correcto se resetea el formulario
          onSuccess: () => {
            if (this.form.recentlySuccessful) {
              let title = "¡Usuario Registrado!";
              let message = "El usuario " +  this.form.name + " fue almacenado.";
              toastr.success(message, title);
            }
            this.form.reset();
          },
        });
      }
    },
    destroy(id) {
      let url = this.route('users.destroy', id);

      Inertia.delete( url, {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
          let success = this.$page.props.flash.success;
          let error = this.$page.props.flash.error;

          if (success) {
            let title = "¡Usuario Eliminado!"
            toastr.success(success, title);
          } else if (error) {
            let message = "El usuario ya no se encuentra almacenado en la base de datos."
            toastr.error(message, error);
          }
        },
      });
    },
  },
};
</script>