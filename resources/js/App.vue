<script setup>
import axios from 'axios';
import { ref } from 'vue';

const kanye_emoji = '/images/kanye-west-emoji.png';
const quotes = ref([]);
const buttonText = ref('Get Quotes');
const possibleButtonTexts = ['More Kanye', 'More!', 'Hit Me', 'I have not seen enough quotes'];

const getQuotes = async () => {
    const response = await axios.get('/kanye-quotes');
    quotes.value = response.data;
    buttonText.value = possibleButtonTexts[Math.floor(Math.random() * possibleButtonTexts.length)];
};


</script>

<template>
     <div>
        <div style="display: flex">
            <h1>
                Kanye's Finest Oratory Moments
            </h1>
            <img :src="kanye_emoji" alt="Kanye West" height="100px" />
        </div>
        <button @click="getQuotes">
            {{ buttonText }}
        </button>
        <ul>
            <li v-for="quote in quotes" :key="quote">
                {{ quote }}
            </li>
        </ul>
    </div>
</template>