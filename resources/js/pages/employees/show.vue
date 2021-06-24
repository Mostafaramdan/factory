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
                                <label><h5 >الراتب : </h5></label>
                            </div>
                            <div class="col-md-3">
                                <b> {{ record.salary }}</b>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-3 ">
                                <label><h5 >نوع الراتب : </h5></label>
                            </div>
                            <div class="col-md-3">
                                <b> {{ record.salary_type=='daily' ? 'يومي' : 'شهري' }}</b>
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
        let response = await this.Api('GET',`employees/${this.$route.params.id}`);
        this.record = response.data.record;
    },
    metaInfo() {
        return {
            title: `${this.$store.state.appName} -  ${this.record.name}`,
        }
    }
}
</script>
