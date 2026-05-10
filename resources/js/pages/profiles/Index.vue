<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    profile: Object,
});

defineOptions({
    layout: AppLayout,
});
</script>

<template>
    <Head title="Tasks" />

    <h1>Profile</h1>

    <div>
        <p>Bio: {{ profile.bio }}</p>
        <p>Story: {{ profile.story }}</p>
    </div>
</template>
