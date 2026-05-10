<script setup lang="ts">
import Heading from '@/components/Heading.vue';
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

const props = defineProps<{
    allUsers: Array<{
        id: number;
        name: string;
        email: string;
        created_at: string;
        updated_at: string;
    }>;
    friends: Array<{
        id: number;
        name: string;
        email: string;
        created_at: string;
        updated_at: string;
    }>;
    pendingRequests: Array<{
        id: number;
        sender_id: number;
        receiver_id: number;
        status: string;
        created_at: string;
        updated_at: string;
        sender: {
            id: number;
            name: string;
            email: string;
            created_at: string;
            updated_at: string;
        };
    }>;
}>();

const friendForm = useForm({
    friendship: null,
    id: null,
});

const addFriend = (value) => {
    friendForm.friendship = value;
    friendForm.id = value.id;
    friendForm.post('friends/' + value.id + '/send', {
        onSuccess: () => {
            console.log('Friend request sent successfully.');
        },
        onError: (errors) => {
            console.error('Error sending friend request:', errors);
        },
    });
};

const acceptRequest = (value) => {
    // Implement accept friend request logic here
    friendForm.friendship = value;
    friendForm.id = value.id;
    friendForm.post('friends/' + value.id + '/accept', {
        onSuccess: () => {
            console.log('Friend request accepted successfully.');
        },
        onError: (errors) => {
            console.error('Error accepting friend request:', errors);
        },
    });
};

const rejectRequest = (value) => {
    // Implement reject friend request logic here
    friendForm.friendship = value;
    friendForm.id = value.id;
    friendForm.post('friends/' + value.id + '/reject', {
        onSuccess: () => {
            console.log('Friend request rejected successfully.');
        },
        onError: (errors) => {
            console.error('Error rejecting friend request:', errors);
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
        <Heading title="All Users" />
        <div v-for="user in props.allUsers" :key="user.id" class="mb-2">
            <span>{{ user.name }} ({{ user.email }})</span>
            <form @submit.prevent="addFriend(user)" class="ml-2 inline-block">
                <button
                    type="submit"
                    class="rounded bg-blue-500 px-2 py-1 font-bold text-white hover:bg-blue-700"
                >
                    Add Friend
                </button>
            </form>
        </div>
    </div>

    <div class="m-5">
        <Heading title="Friends" />
        <div v-for="friend in props.friends" :key="friend.id" class="mb-2">
            <span>{{ friend.name }} ({{ friend.email }})</span>
        </div>
    </div>
    <div class="m-5">
        <Heading title="Friend Requests" />
        <div
            v-for="request in props.pendingRequests"
            :key="request.id"
            class="mb-2"
        >
            <span>{{ request.sender.name }} ({{ request.sender.email }})</span>
            <!-- Add buttons for accepting/rejecting friend requests here -->
            <form
                @submit.prevent="acceptRequest(request)"
                class="ml-2 inline-block"
            >
                <button
                    type="submit"
                    class="rounded bg-green-500 px-2 py-1 font-bold text-white hover:bg-green-700"
                >
                    Accept
                </button>
            </form>
            <form
                @submit.prevent="rejectRequest(request)"
                class="ml-2 inline-block"
            >
                <button
                    type="submit"
                    class="rounded bg-red-500 px-2 py-1 font-bold text-white hover:bg-red-700"
                >
                    Reject
                </button>
            </form>
        </div>
    </div>
</template>
