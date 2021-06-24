<template >
    <div>

        <div class="row row-cols-1 row-cols-md-1 ">
            <div class="col">
                <div class="card " >
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 ">
                                <label><h5 >الاسم : </h5></label>
                            </div>
                            <div class="col-md-3">
                                <b> {{ record.name }}</b>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-3 ">
                                <label><h5 >رقم التليفون : </h5></label>
                            </div>
                            <div class="col-md-3">
                                <b> {{ record.phone }}</b>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-3 ">
                                <label><h5 >العنوان : </h5></label>
                            </div>
                            <div class="col-md-3">
                                <b> {{ record.address }}</b>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-3 ">
                                <label><h5 >الديون : </h5></label>
                            </div>
                            <div class="col-md-3">
                                <b> {{ record.debits }} ج</b>
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
        }
    },
    methods:{
    },
    async mounted(){
        this.$store.state.isLoading = false;
        let response = await this.Api('GET',`clients/${this.$route.params.id}`);
        this.record = response.data.record;
    },
    metaInfo() {
        return {
            title: `${this.$store.state.appName} -  ${this.record.name}`,
        }
    }
}
</script>
