<template>
    <div>
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-10 lg:px-8 lg:flex lg:items-center lg:justify-between">
            <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                <span class="block">Variations</span>
            </h2>
        </div>

        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 py-6 sm:px-0">
                <div class="border-4 border-dashed border-gray-200 rounded-lg min-h-[3.23rem] grid grid-cols-3 gap-4">
                    <div v-for="(num, index) in rowsLength" :key="`variation-${index}`"
                         style="width: 200px; height: 200px"
                         class="border-black h-12 rounded-md flex items-center justify-center mx-auto">
                        <canvas width="200" height="200"
                                :ref="el => { canvases[index] = el }"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
            <div></div>
            <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
                <div class="ml-3 inline-flex rounded-md shadow">
                    <reset-db-button></reset-db-button>
                </div>
                <div class="ml-3 inline-flex rounded-md shadow">
                    <generate-button @generated="onGeneratedData"></generate-button>
                </div>
                <div class="ml-3 inline-flex rounded-md shadow">
                    <image-upload-button></image-upload-button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import JetButton from '../Jetstream/Button.vue'
import ResetDbButton from '../Components/ResetDbButton.vue'
import GenerateButton from '../Components/GenerateButton.vue'
import ImageUploadButton from '../Components/ImageUploadButton.vue'

import {ref, reactive, onBeforeUpdate} from 'vue'

export default {
    components: {ResetDbButton, JetButton, GenerateButton, ImageUploadButton},

    setup() {
        const variations = reactive({value: []});

        const canvases = ref([])

        const rowsLength = ref(0);

        onBeforeUpdate(() => {
            canvases.value = [];
        })

        function drawImages() {
            for (let index = 0; index < rowsLength.value; index++) {
                const ctx = canvases.value[index].getContext('2d')

                variations.value.forEach((variationGroup) => {
                    const filename = variationGroup[index]

                    const img = new Image;

                    img.onload = function () {
                        ctx.drawImage(img, 0, 0, 200, 200);
                    };

                    img.src = `http://localhost/storage/images/${filename}`;
                })
            }
        }

        return {
            canvases,
            variations,
            rowsLength,

            onGeneratedData(data) {
                variations.value = []
                rowsLength.value = 0

                if (data?.length) {
                    variations.value = data
                    rowsLength.value = data[0]?.length ?? 0
                }

                setTimeout(() => {
                    drawImages()
                }, 1000)
            },
        }
    }
}
</script>

<style scoped>

</style>
