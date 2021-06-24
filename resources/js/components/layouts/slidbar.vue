<template>
    <div>
        <b-sidebar
            id="sidebar-right"
            :title="' مرحبا ' + $store.getters.getUser.name"
            right
            shadow
            style="width: 100%"
        >
            <div class="px-3 py-2">
                <b-list-group>
                    <router-link :to="{name: 'statistics'}" >
                        <b-list-group-item
                        v-if=" permissions.statistics && permissions.statistics.permissions.view"
                        :active="$route.name.includes('statistics')">
                            الاحصائيات
                        </b-list-group-item >
                    </router-link>
                    <router-link :to="{name: 'productions'}"
                        v-if=" permissions.productions && permissions.productions.permissions.view"
                    >
                        <b-list-group-item
                            :active="$route.name.includes('productions')">
                             الإنتاج
                        </b-list-group-item >
                    </router-link>
                    <router-link :to="{name: 'orders'}"
                        v-if=" permissions.orders && permissions.orders.permissions.view"
                    >
                        <b-list-group-item
                            :active="$route.name.includes('orders')">
                             الطلبات
                        </b-list-group-item >
                    </router-link>
                    <router-link :to="{name: 'returnedOrders'}"
                        v-if=" permissions.returnedOrders && permissions.returnedOrders.permissions.view"
                    >
                        <b-list-group-item
                            :active="$route.name.includes('returnedOrders')">
                             المرتجع
                        </b-list-group-item >
                    </router-link>
                    <router-link :to="{name: 'bills'}"
                        v-if=" permissions.bills && permissions.bills.permissions.view"
                    >
                        <b-list-group-item
                            :active="$route.name.includes('bills')">
                             الفواتير
                        </b-list-group-item >
                    </router-link>
                    <router-link :to="{name: 'clients'}"
                        v-if=" permissions.clients && permissions.clients.permissions.view"
                    >
                        <b-list-group-item
                            :active="$route.name.includes('clients')">
                             العملاء
                        </b-list-group-item >
                    </router-link>

                    <router-link :to="{name: 'variable_costs'}"
                        v-if=" permissions.variable_costs && permissions.variable_costs.permissions.view"
                    >
                        <b-list-group-item
                            :active="$route.name.includes('variable_costs')">
                             تكاليف متغيرة
                        </b-list-group-item >
                    </router-link>
                    <router-link :to="{name: 'matrials_types'}"
                        v-if=" permissions.matrials_types && permissions.matrials_types.permissions.view"
                    >
                        <b-list-group-item
                            :active="$route.name.includes('matrials_types')">
                              المواد الخام
                        </b-list-group-item >
                    </router-link>
                    <router-link :to="{name: 'employees'}"
                        v-if=" permissions.employees && permissions.employees.permissions.view"
                    >
                        <b-list-group-item
                            :active="$route.name.includes('employees')">
                             الموظفين
                        </b-list-group-item >
                    </router-link>
                    <router-link :to="{name: 'admins'}"
                        v-if=" permissions.employees && permissions.employees.permissions.view"
                    >
                        <b-list-group-item :active="$route.name.includes('admins')">
                             المسؤولين
                        </b-list-group-item >
                    </router-link>
                </b-list-group>
            </div>
        </b-sidebar>
    </div>
</template>
<script>
export default {
    data() {
        return {
            userLink: "users",
            allPermissions: this.$store.state.user.permissions ? this.$store.state.user.permissions : null
        };
    },

};
</script>

