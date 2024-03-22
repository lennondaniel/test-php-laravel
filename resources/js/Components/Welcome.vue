<script setup>
import moment from "moment";
import 'moment/locale/pt-br'
moment.locale('pt-br');
const props = defineProps({
    weather: Object,
});
const weatherObj = JSON.parse(JSON.stringify(props.weather)).weather;
function getDayOfWeek(timestamp) {
    return moment.unix(timestamp).format('ddd. DD');
}
</script>

<template>
    <div>
        <div class="p-6 bg-white border-b border-gray-200">
            <h3 class="text-3xl font-bold text-gray-500 capitalize">{{ weatherObj.city }}</h3>
        </div>

        <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 p-6 lg:p-8">
            <div>
                <div class="flex items-center">
                    <!-- component -->
                    <div class="h-full w-full relative  shadow-md rounded-xl overflow-hidden group ">
                        <div class="absolute w-full h-full bg-opacity-50 bg-gray-600">
                            <div class="w-full h-full p-5 relative">
                                <div class="absolute top-0 text-white text-left">
                                    <p class="text-lg font-medium mb-7 text-white capitalize">{{ weatherObj.city }}</p>
                                    <h2 class="text-7xl font-bold text-white mb-0 pb-1">{{ `${parseInt(weatherObj.data_weather.current.temp)}°` }}</h2>
                                    <p class="text-lg font-light text-white capitalize">{{ weatherObj.data_weather.current.weather[0].description }}</p>
                                    <p class="text-lg font-light text-white">
                                        {{
                                            `Dia ${parseInt(weatherObj.data_weather.daily[0].temp.day)}° •
                                            Noite ${parseInt(weatherObj.data_weather.daily[0].temp.night)}°`
                                        }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <img src="https://fia.com.br/wp-content/uploads/2020/08/ff3.jpg" class="w-full z-0 h-full object-fill example ">
                    </div>
                </div>
            </div>
            <div>
                <div class="flex items-center">
                    <div class="flex items-center justify-center">
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white shadow-md rounded-xl">
                                <thead>
                                <tr class="bg-blue-gray-100 text-gray-700">
                                    <th colspan="3" class="py-3 px-4 text-left">Previsão para os próximos dias</th>
                                </tr>
                                </thead>
                                <tbody class="text-blue-gray-900" v-for="item in weatherObj.data_weather.daily">
                                <tr class="border-b border-blue-gray-200">
                                    <td class="py-3 px-4">{{ getDayOfWeek(item.dt)}}</td>
                                    <td class="py-3 px-4">{{  `${parseInt(item.temp.max)}°\\${parseInt(item.temp.min)}°` }}</td>
                                    <td class="py-3 px-4 capitalize">{{ item.weather[0].description }}</td>
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
