<template>
    <div class="pt-0 card-datatable table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th width="1%">#</th>
                    <th>Region</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Account Type</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(user, index) in users" :key="index">
                    <td>{{ index + 1 }}</td>
                    <td>{{ user.region }}</td>
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.phone }}</td>
                    <td>{{ user.account_type }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
  
<script lang="ts">
import { defineComponent } from 'vue';

interface User {
    region: string;
    name: string;
    email: string;
    phone: string;
    account_type: string;
}

export default defineComponent({
    data() {
        return {
            users: [] as User[],
        };
    },
});
</script>
  