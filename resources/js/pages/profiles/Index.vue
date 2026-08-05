<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    user: Object,
});

defineOptions({
    layout: AppLayout,
});

const page = usePage();

const logged_user = computed(() => page.props.auth?.user);
const friends = computed(() => page.props.auth?.friends || []);
const isFriend = computed(() => {
    if (!logged_user.value || !props.user) {
        return false;
    }
    return friends.value.some((friend: any) => friend.id === props.user.id);
});

const form = useForm({
    bio: props.user?.profile?.bio || '',
    story: props.user?.profile?.story || '',
});

const isStoryExpanded = ref(false);

const toggleStory = () => {
    isStoryExpanded.value = !isStoryExpanded.value;
};
</script>

<template>
    <Head title="Profile" />

    <div class="min-h-screen bg-gray-50 px-4 py-10 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-3xl">
            <!-- profile.bio Block -->
            <div
                class="mb-6 overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm"
            >
                <div
                    class="h-32 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"
                ></div>
                <div class="relative px-6 pb-6 text-center sm:text-left">
                    <!-- Avatar -->
                    <div
                        class="-mt-16 mb-4 flex justify-center sm:justify-start"
                    >
                        <img
                            class="h-28 w-28 rounded-full border-4 border-white object-cover shadow-sm"
                            :src="
                                props.user?.profile?.avatar ||
                                'https://unsplash.com'
                            "
                            alt="User Avatar"
                        />
                    </div>

                    <!-- User Meta & Bio -->
                    <div
                        class="flex flex-col sm:flex-row sm:items-end sm:justify-between"
                    >
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">
                                {{ props.user?.name || 'Jane Doe' }}
                            </h3>
                            <p class="text-sm font-medium text-indigo-600">
                                {{
                                    props.user?.title ||
                                    'Senior Software Engineer'
                                }}
                            </p>
                            <p class="mt-1 text-sm text-gray-500">
                                <svg
                                    class="mr-1 inline h-4 w-4"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                                    ></path>
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                                    ></path>
                                </svg>
                                {{
                                    props.user?.location || 'San Francisco, CA'
                                }}
                            </p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-6 flex justify-center gap-3 sm:mt-0">
                            <div v-if="isFriend" class="flex gap-2">
                                <button
                                    class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm transition hover:bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-none"
                                >
                                    Message
                                </button>
                            </div>
                            <div v-else class="flex gap-2">
                                <button
                                    class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm transition hover:bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-none"
                                >
                                    Add Friend
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Bio Description -->
                    <div class="mt-6 border-t border-gray-100 pt-6">
                        <p
                            class="max-w-2xl text-sm leading-relaxed text-gray-600"
                        >
                            {{
                                props.user?.profile?.bio ||
                                'Passionate about building scalable web applications and designing beautiful user interfaces. Always excited to collaborate on open-source projects and share knowledge with the dev community.'
                            }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- profile.story Block -->
            <div
                class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm"
            >
                <div
                    class="flex items-center justify-between border-b border-gray-100 px-6 py-5"
                >
                    <h4 class="text-lg font-semibold text-gray-900">
                        My Story
                    </h4>
                    <button
                        @click="toggleStory"
                        class="text-sm font-medium text-indigo-600 transition hover:text-indigo-500 focus:outline-none"
                    >
                        {{
                            isStoryExpanded
                                ? 'Collapse Story'
                                : 'Read Full Story'
                        }}
                    </button>
                </div>

                <div class="px-6 py-6">
                    <!-- Shortened View -->
                    <div
                        v-if="!isStoryExpanded"
                        class="prose prose-sm line-clamp-3 text-gray-600"
                    >
                        <p>
                            {{
                                props.user?.profile?.story ||
                                'My journey in tech began with a simple "Hello World" and has evolved into architecting robust backend systems and intuitive frontend architectures. I believe that good code tells a story, and I am always looking for my next chapter...'
                            }}
                        </p>
                    </div>

                    <!-- Expanded View -->
                    <div
                        v-else
                        class="prose prose-sm animate-fade-in-down space-y-4 text-gray-600"
                    >
                        <p>
                            {{
                                props.user?.profile?.story ||
                                'My journey in tech began with a simple "Hello World" and has evolved into architecting robust backend systems and intuitive frontend architectures. I believe that good code tells a story, and I am always looking for my next chapter.'
                            }}
                        </p>
                        <p>
                            Over the past few years, I have specialized in the
                            Laravel and Vue ecosystems. From optimizing database
                            queries to fine-tuning state management and building
                            reusable component libraries, my focus has always
                            been on delivering seamless user experiences.
                        </p>
                        <p>
                            When I am not in front of a screen, you can usually
                            find me contributing to open-source libraries,
                            reading up on the latest architectural patterns, or
                            hiking the local trails to clear my mind for the
                            next sprint.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
