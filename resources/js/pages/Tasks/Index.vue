<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import Task from '@/components/Task.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

const Props = defineProps<{
    tasks: Array<{
        id: number;
        title: string;
        description: string | null;
        is_completed: boolean;
        due_date: string | null;
        created_at: string;
        updated_at: string;
    }>;
}>();

const taskForm = useForm({
    id: null,
    title: '',
    description: '',
    is_completed: false,
    due_date: '',
});

const updateStatus = (value) => {
    taskForm.title = value.title;
    taskForm.description = value.description;
    taskForm.is_completed = !value.is_completed;
    taskForm.due_date = value.due_date;
    taskForm.put('tasks/' + value.id, {
        onSuccess: () => {
            console.log('Task status updated successfully.');
        },
        onError: (errors) => {
            console.error('Error updating task status:', errors);
        },
    });
};

const deleteTask = (value) => {
    taskForm.delete('tasks/' + value.id, {
        onSuccess: () => {
            console.log('Task deleted successfully.');
        },
        onError: (errors) => {
            console.error('Error deleting task:', errors);
        },
    });
};

defineOptions({
    layout: AppLayout,
});
</script>

<template>
    <Head title="Tasks" />

    <div class="m-5">
        <Heading title="Tasks" description="Welcome to your tasks dashboard!" />

        <h2>Tasks</h2>
        <ul v-for="task in tasks">
            <Task
                :task="task"
                @update-status="updateStatus(task)"
                @delete-task="deleteTask(task)"
            />
        </ul>
    </div>
</template>
