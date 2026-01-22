<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { watch } from 'vue';

import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem, type User } from '@/types';
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

interface PaginatedResponse<T> {
    data: T[];
    links: any[]; // Simplified for now
    meta?: any;
    current_page: number;
    // ... add other pagination fields as needed
}

const props = defineProps<{
    users: PaginatedResponse<User>;
    search?: string;
    perPage?: number;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Users',
        href: '/users',
    },
];

const perPage = ref(props.perPage || 10);
const search = ref(props.search || '');

let searchTimeout: ReturnType<typeof setTimeout>;

watch(search, (value) => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        router.get(
            '/admin/users',
            { search: value, perPage: perPage.value },
            { preserveState: true, replace: true }
        );
    }, 300);
});

watch(perPage, (value) => {
    router.get(
        '/admin/users',
        { search: search.value, perPage: value },
        { preserveState: true, replace: true }
    );
});
</script>

<template>
    <Head title="Users" />

    <AppLayout :breadcrumbs="breadcrumbs">
        
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
        <button>
            <Link href="/admin/users/create" class="text-blue-500 hover:underline">Create User</Link>
        </button>
        <input type="text" v-model="search" placeholder="Search users..." class="border p-2 rounded" />
        <select v-model="perPage" class="border p-2 rounded">
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
             <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border p-4"
             >
                <h1 class="text-2xl font-bold mb-4">Users</h1>
                <p>Users content goes here.</p>
                <div class="mt-6 overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr class="border-b dark:border-sidebar-border text-sidebar-foreground/70">
                                <th class="pb-2 font-semibold">Name</th>
                                <th class="pb-2 font-semibold">Email</th>
                                <th class="pb-2 font-semibold text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y dark:divide-sidebar-border">
                            <tr v-for="user in users.data" :key="user.id">
                                <td class="py-3 font-medium">{{ user.name }}</td>
                                <td class="py-3">{{ user.email }}</td>
                                <td class="py-3 text-right">
                                    <button class="mr-2">
                                        <Link :href="`/admin/users/${user.id}/edit`" class="text-blue-500 hover:underline">Edit</Link>
                                    </button>
                                    <button class="mr-2">
                                        <Link :href="`/admin/users/${user.id}/delete`" class="text-red-500 hover:underline">Delete</Link>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <PlaceholderPattern />
            </div>
        </div>
    </AppLayout>
</template>
