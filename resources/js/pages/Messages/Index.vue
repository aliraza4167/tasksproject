<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

const Props = defineProps<{
    received_messages: Array<{
        id: number;
        sender: {
            id: number;
            name: string;
            email: string;
        };
        receiver: {
            id: number;
            name: string;
            email: string;
        };
        content: string;
        created_at: string;
        updated_at: string;
    }>;
    sent_messages: Array<{
        id: number;
        sender: {
            id: number;
            name: string;
            email: string;
        };
        receiver: {
            id: number;
            name: string;
            email: string;
        };
        content: string;
        created_at: string;
        updated_at: string;
    }>;
}>();

const messageForm = useForm({
    content: '',
});

const showReceivedMessages = ref(false);
const showSentMessages = ref(false);

// const updateStatus = (value) => {
//     taskForm.title = value.title;
//     taskForm.description = value.description;
//     taskForm.is_completed = !value.is_completed;
//     taskForm.due_date = value.due_date;
//     taskForm.put('tasks/' + value.id, {
//         onSuccess: () => {
//             console.log('Task status updated successfully.');
//         },
//         onError: (errors) => {
//             console.error('Error updating task status:', errors);
//         },
//     });
// };

// const deleteTask = (value) => {
//     taskForm.delete('tasks/' + value.id, {
//         onSuccess: () => {
//             console.log('Task deleted successfully.');
//         },
//         onError: (errors) => {
//             console.error('Error deleting task:', errors);
//         },
//     });
// };

defineOptions({
    layout: AppLayout,
});
</script>

<template>
    <Head title="Tasks" />

    <Heading
        class="mt-4"
        title="Messages"
        description="View and manage your messages."
        :breadcrumbs="breadcrumbs"
    />

    <div class="mt-6">
        <h2
            class="my-4 rounded py-2 text-2xl font-semibold hover:cursor-pointer hover:bg-blue-100"
            @click="() => (showReceivedMessages = !showReceivedMessages)"
        >
            Inbox
        </h2>
        <div v-if="showReceivedMessages">
            <div v-if="received_messages.length === 0" class="text-gray-500">
                No received messages found.
            </div>
            <ul v-else class="space-y-4">
                <li
                    v-for="message in received_messages"
                    :key="message.id"
                    class="rounded-lg border border-gray-200 p-4"
                >
                    <div class="mb-2">
                        <strong>From:</strong> {{ message.sender.name }} ({{
                            message.sender.email
                        }})
                    </div>
                    <!-- <div class="mb-2">
                        <strong>To:</strong> {{ message.receiver.name }} ({{
                            message.receiver.email
                        }})
                    </div>
                    <div class="mb-2">
                        <strong>Message:</strong>
                        <p class="mt-1 text-gray-700">{{ message.content }}</p>
                    </div> -->
                    <div class="text-sm text-gray-500">
                        Sent on:
                        {{ new Date(message.created_at).toLocaleString() }}
                    </div>
                </li>
            </ul>
        </div>
        <h2
            class="my-4 rounded py-2 text-2xl font-semibold hover:cursor-pointer hover:bg-blue-100"
            @click="() => (showSentMessages = !showSentMessages)"
        >
            Sent Messages
        </h2>
        <div v-if="showSentMessages">
            <div v-if="sent_messages.length === 0" class="text-gray-500">
                No sent messages found.
            </div>
            <ul v-else class="space-y-4">
                <li
                    v-for="message in sent_messages"
                    :key="message.id"
                    class="rounded-lg border border-gray-200 p-4"
                >
                    <div class="mb-2">
                        <strong>From:</strong> {{ message.sender.name }} ({{
                            message.sender.email
                        }})
                    </div>
                    <div class="mb-2">
                        <strong>To:</strong> {{ message.receiver.name }} ({{
                            message.receiver.email
                        }})
                    </div>
                    <div class="mb-2">
                        <strong>Message:</strong>
                        <p class="mt-1 text-gray-700">{{ message.content }}</p>
                    </div>
                    <div class="text-sm text-gray-500">
                        Sent on:
                        {{ new Date(message.created_at).toLocaleString() }}
                    </div>
                </li>
            </ul>
        </div>

        <!-- <div v-if="messages.length === 0" class="text-gray-500">
            No messages found.
        </div>
        <ul v-else class="space-y-4">
            <li
                v-for="message in messages"
                :key="message.id"
                class="rounded-lg border border-gray-200 p-4"
            >
                <div class="mb-2">
                    <strong>From:</strong> {{ message.sender.name }} ({{
                        message.sender.email
                    }})
                </div>
                <div class="mb-2">
                    <strong>To:</strong> {{ message.receiver.name }} ({{
                        message.receiver.email
                    }})
                </div>
                <div class="mb-2">
                    <strong>Message:</strong>
                    <p class="mt-1 text-gray-700">{{ message.content }}</p>
                </div>
                <div class="text-sm text-gray-500">
                    Sent on: {{ new Date(message.created_at).toLocaleString() }}
                </div>
            </li>
        </ul> -->
    </div>
</template>
