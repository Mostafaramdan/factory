<template >
    <div class="row" >
        <div class="col-md-4 m-2">
            <label for="from" class="form-label"> من : </label>
            <input type="date" class="form-control" v-model="from" id="from">
        </div>
        <div class="col-md-4 m-2">
            <label for="to" class="form-label"> الي : </label>
            <input type="date" class="form-control"  v-model="to" id="to">
        </div>
        <hr>
        <div class="col  text-white bg-primary  m-3" style="max-width: 18rem;">
            <div class="card-text m-2 text-wrap">اجمالي الطلبات </div>
            <hr><div class="card-body">
                <h5 class="card-title">{{record.orders}}</h5>
            </div>
        </div>

        <div class="col  text-white bg-dark  m-3" style="max-width: 18rem;">
            <div class="card-text m-2 text-wrap">اجمالي الكمية المباعة  </div>
            <hr><div class="card-body">
                <h5 class="card-title">{{record.quantity}} كجم</h5>
            </div>
        </div>

        <div class="col  text-white bg-primary  m-3" style="max-width: 18rem;">
            <div class="card-text m-2 text-wrap">اجمالي المبيعات  </div>
            <hr><div class="card-body">
                <h5 class="card-title">{{ parseFloat(record.quantity) * parseFloat(record.price)}} ج</h5>
            </div>
        </div>
        <div class="col  text-white bg-dark  m-3" style="max-width: 18rem;">
            <div class="card-text m-2 text-wrap">اجمالي الارباح  </div>
            <hr><div class="card-body">
                <h5 class="card-title" v-if="record.profits">{{record.profits.toFixed(3)}} ج</h5>
            </div>
        </div>

        <hr>
        <div class="col  text-white bg-primary  m-3" style="max-width: 18rem;">
            <div class="card-text m-2 text-wrap">اجمالي كمية الانتاج   </div>
            <hr><div class="card-body">
                <h5 class="card-title">{{record.total_quantity}} كجم</h5>
            </div>
        </div>
        <div class="col  text-white bg-dark  m-3" style="max-width: 18rem;">
            <div class="card-text m-2 text-wrap">اجمالي تكلفة الانتاج  </div>
            <hr><div class="card-body">
                <h5 class="card-title">{{ parseFloat(record.expenses) }} ج</h5>
            </div>
        </div>
        <hr>
        <div class="col  text-white bg-success  m-3" style="max-width: 18rem;" v-for="(total_prodcution,index) in record.total_productions" :key="index">
            <div class="card-text m-2 text-wrap">اجمالي  كمية {{total_prodcution.production_type.name}} الموجودة  </div>
            <hr><div class="card-body">
                <h5 class="card-title">{{ parseFloat(total_prodcution.total) }} كجم</h5>
            </div>
        </div>
        <div class="col  text-white bg-primary  m-3" style="max-width: 18rem;">
            <div class="card-text m-2 text-wrap">اجمالي تكلفة العمالة في اليوم  </div>
            <hr>
            <div class="card-body">
                <h5 class="card-title">{{ parseFloat(record.salaries) }} ج</h5>
            </div>
        </div>

        <!-- <hr>
            <a href="/download-orders" class="btn btn-success">تحميل في ملف <i class="fas fa-file-excel"></i> </a>
        -->
    </div>
</template>
<script>

export default {
    data(){
        return {
            record:{},
            from:'',
            to:'',
            visible:false
        }
    },
    methods:{
        update(index){
             this.$router.push( {name:'statisticsUpdate', params: { id: this.record.id }});
        },
        async getRecords(){
            this.$store.state.isLoading = true;
            let response = await this.Api('GET','statistics',{from:this.from,to:this.to});
            this.record=response.data.record ;
            this.$store.state.isLoading = false;
        },
    },
    async mounted(){
        await this.getRecords();
    },
    watch: {
        from:function(c){
            this.getRecords();
        },
        to:function(){
            this.getRecords();
        },
    },
    metaInfo() {
        return {
            title: `${this.$store.state.appName} -   الاحصائيات `,
        }
    },
}
</script>
s
