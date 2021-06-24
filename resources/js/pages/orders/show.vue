<template >
    <div>

        <div class="row row-cols-1 row-cols-md-1 ">
            <div class="col">
                <div class="card " >
                    <div class="card-body">
                        <div class="row" v-if="record.client">
                            <div class="col-md-3 ">
                                <label><h5 >العميل : </h5></label>
                            </div>
                            <div class="col-md-3">
                                <b> <router-link :to="{name: 'clientsShow',params:{id:record.clients_id}}"
                                    >{{ record.client.name }}</router-link ></b>
                            </div>
                        </div>
                        <hr>
                        <div class="row" v-if="record.employee">
                            <div class="col-md-3 ">
                                <label><h5 >السائق : </h5></label>
                            </div>
                            <div class="col-md-3">
                                <b> <router-link :to="{name: 'employeesShow',params:{id:record.employees_id}}"
                                    >{{ record.employee.name }}</router-link ></b>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-3 ">
                                <label><h5 >الكمية : </h5></label>
                            </div>
                            <div class="col-md-3">
                                <b> {{ record.quantity }}</b>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-3 ">
                                <label><h5 >سعر الكليو : </h5></label>
                            </div>
                            <div class="col-md-3">
                                <b> {{ record.price }} ج</b>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-3 ">
                                <label><h5 >الاجمالي : </h5></label>
                            </div>
                            <div class="col-md-3">
                                <b>{{record.price * record.quantity}} ج</b>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-3 ">
                                <label><h5 >الارباح : </h5></label>
                            </div>
                            <div class="col-md-3">
                                <b> {{ record.profits }} ج</b>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-3 ">
                                <label><h5 >تاريخ الطلب : </h5></label>
                            </div>
                            <div class="col-md-3">
                                <b> {{ record.created_at }} </b>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    components:{
    },
    data(){
        return {
            record:{},
            slide: 0,
            sliding: null,
            visible:false
        }
    },
    methods:{
    },
    async mounted(){
        this.$store.state.isLoading = false;
        let response = await this.Api('GET',`orders/${this.$route.params.id}`);
        this.record = response.data.record;
    },
    metaInfo() {
        return {
            title: `${this.$store.state.appName} -  ${this.record.name}`,
        }
    }
}
</script>
