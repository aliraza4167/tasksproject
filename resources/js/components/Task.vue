<script setup lang="ts">
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { useForm } from '@inertiajs/vue3';
import Button from './ui/button/Button.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

const props = defineProps<{
    task: {
        id: number;
        title: string;
        description: string | null;
        is_completed: boolean;
        due_date: string | null;
        created_at: string;
        updated_at: string;
    };
}>();

const taskForm = useForm({
    id: null,
    title: '',
    description: '',
    is_completed: false,
    due_date: '',
});

defineEmits(['updateStatus', 'deleteTask', 'editTask']);
</script>

<template>
    <li class="m-2 flex rounded-md bg-gray-800 p-5 text-white">
        <div :class="{ 'line-through': task.is_completed }">
            {{ task.title }}
        </div>

        <div>
            <form @submit.prevent="$emit('updateStatus', task)" class="inline">
                <Button
                    type="submit"
                    class="ml-5 justify-end rounded-md bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
                >
                    <span>
                        {{
                            task.is_completed
                                ? 'Mark as Incomplete'
                                : 'Mark as Complete'
                        }}
                    </span>
                </Button>
            </form>
            <form @submit.prevent="$emit('deleteTask', task)" class="inline">
                <Button
                    type="submit"
                    class="ml-5 justify-end rounded-md bg-red-600 px-4 py-2 text-white hover:bg-red-700"
                >
                    Delete
                </Button>
            </form>
            <form @submit.prevent="$emit('editTask', task)" class="inline">
                <Button
                    class="ml-5 justify-end rounded-md bg-green-600 px-4 py-2 text-white hover:bg-green-700"
                    >Edit</Button
                >
            </form>
        </div>
    </li>
</template>
