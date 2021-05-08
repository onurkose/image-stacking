<template>
    <span>
        <jet-button @click="addNewImage = true">Add new image</jet-button>

        <jet-dialog-modal :show="addNewImage" @close="closeModal">
            <template #title>
                Add new image
            </template>

            <template #content>
                <div class="mt-4">
                    <jet-label for="arrayIndex" value="Array Index:"/>

                    <jet-input type="number" min="0" max="4" class="mt-1 block w-full" placeholder="0"
                               id="arrayIndex"
                               v-model="form.arrayIndex"
                               @keyup.enter="uploadImages"/>
                </div>

                <div class="mt-4">
                    <jet-label value="Files:"/>
                    <input type="file" @change="collectFiles" multiple/>
                    <jet-input-error :message="form.error" class="mt-2"/>
                </div>
            </template>

            <template #footer>
                <jet-secondary-button @click="closeModal">
                    Cancel
                </jet-secondary-button>

                <jet-button class="ml-2" @click="uploadImages" :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing">
                    Add
                </jet-button>
            </template>
        </jet-dialog-modal>

        <jet-dialog-modal :show="displayImageUploadResult" @close="closeModal">
            <template #content>
                <p>Your files were successfully uploaded!</p>
            </template>

            <template #footer>
                <jet-secondary-button @click="closeModal">
                    OK
                </jet-secondary-button>
            </template>
        </jet-dialog-modal>
    </span>
</template>

<script>
import JetButton from '../Jetstream/Button.vue';
import JetSecondaryButton from '../Jetstream/SecondaryButton.vue';
import JetDialogModal from '../Jetstream/DialogModal.vue'
import JetModal from '../Jetstream/Modal.vue'
import JetLabel from '../Jetstream/Label.vue'
import JetInput from '../Jetstream/Input.vue'
import JetInputError from '../Jetstream/InputError.vue'

import {ref, reactive} from 'vue'

export default {
    components: {JetButton, JetSecondaryButton, JetDialogModal, JetModal, JetLabel, JetInput, JetInputError},

    setup(props) {
        const addNewImage = ref(false),
            displayImageUploadResult = ref(false),
            hiddenFileInput = ref(),
            form = reactive({
                arrayIndex: 0,
                files: {},
                error: null,
                processing: false,
            })

        return {
            addNewImage,
            displayImageUploadResult,
            hiddenFileInput,
            form,

            collectFiles(event) {
                form.files = event.target.files
            },

            uploadImages() {
                form.processing = true

                const formData = new FormData();

                formData.append('array_index', `${form.arrayIndex}`);

                for (const i of Object.keys(form.files)) {
                    formData.append('files[]', form.files[i])
                }

                axios.post('http://localhost/upload', formData, {}).then((res) => {
                    addNewImage.value = false
                    displayImageUploadResult.value = true
                }).catch((err) => {
                    form.error = err?.response?.data?.message ?? err?.message
                }).then(() => {
                    form.processing = false
                })
            },

            closeModal() {
                addNewImage.value = false
                form.error = null
                displayImageUploadResult.value = false
            },
        }
    }
}
</script>
