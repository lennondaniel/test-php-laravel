<script setup>

import moment from "moment";

const props = defineProps({
    weathers: Object,
});
const weathersObj = JSON.parse(JSON.stringify(props.weathers)).weathers;
const formatDate = (date) => {
    return moment(date).format('DD/MM/YYYY HH:mm:ss')
}
</script>

<template>
    <div>
        <div class="p-6 bg-white border-b border-gray-200">
            <h3 class="text-3xl font-bold text-gray-500 capitalize">Cidades Salvas</h3>
        </div>

        <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 p-6 lg:p-8">
            <div>
                <div class="flex items-center">
                    <div class="flex items-center justify-center">
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white shadow-md rounded-xl">
                                <thead>
                                <tr class="bg-blue-gray-100 text-gray-700">
                                    <th class="py-3 px-4 text-left">Cidade</th>
                                    <th class="py-3 px-4 text-left">Latitude</th>
                                    <th class="py-3 px-4 text-left">Longitude</th>
                                    <th class="py-3 px-4 text-left">Ultima atualização</th>
                                </tr>
                                </thead>
                                <tbody class="text-blue-gray-900" v-for="item in weathersObj">
                                <tr class="border-b border-blue-gray-200">
                                    <td class="py-3 px-4 capitalize">{{ item.city }}</td>
                                    <td class="py-3 px-4">{{ item.lat }}</td>
                                    <td class="py-3 px-4">{{ item.lon }}</td>
                                    <td class="py-3 px-4">{{ formatDate(item.updated_at) }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
