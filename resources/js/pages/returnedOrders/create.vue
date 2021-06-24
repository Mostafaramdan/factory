<template>
    <div class="m-3" >
    <form  @submit.prevent="onSubmit" class="border border-5 border-primary rounded form">
        <h3>
            {{titlePage}}
        </h3>
        <hr>
        <div class="form-check ">
            <label  > ادخل نوع المنتج  </label>
            <select type="text" v-model="record.production_type_id" :class="['form-control',{'is-valid':record.production_type_id > 0 },{'is-invalid':!record.production_type_id > 0}]"  >
                <option value="1" >جبنة</option>
                <option value="2" >خصرة</option>
            </select>
            <div class="valid-feedback">
                صحيح
            </div>
            <div class="invalid-feedback">
                <span>يجب إختيار نوع المنتج   </span>
            </div>

        </div>

        <div class="form-check ">
            <label  > ادخل الكمية  </label>
            <input type="number" v-model="record.quantity" :class="['form-control' ,{'is-valid':validateQuantity },{'is-invalid':!validateQuantity}]"  >
            <div class="valid-feedback">
                     صحيح
            </div>
            <div class="invalid-feedback">
                <span>يجب إدخال الكمية بشكل صحيح</span>
            </div>
        </div>
        <div class="form-check ">
            <label  > ادخل سعر الكيلو  </label>
            <input type="number" v-model="record.price" :class="['form-control' ,{'is-valid':validatePrice },{'is-invalid':!validatePrice}]"  >
            <div class="valid-feedback">
                     صحيح
            </div>
            <div class="invalid-feedback">
                <span>يجب إدخال سعر الكيلو بشكل صحيح</span>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-6">
                <label >متوسط سعر الكليو علي المصنع</label>
                <input class="form-control" readonly :value='averagePrice'>
            </div>
            <div class="col-6">
                <label >  الاجمالي</label>
                <input class="form-control" readonly :value='total'>
            </div>
        </div>
        <hr>
        <dropdown-menu
            model="clients"
            @choosen='record.clients_id = $event'
            :records_id='record.clients_id'
            column='name'
            label='العميل'
            >
        </dropdown-menu>
        <hr>
        <dropdown-menu
            model="employees"
            @choosen='record.employees_id = $event'
            :records_id='record.employees_id'
            column='name'
            label='السائق'
            >
        </dropdown-menu>
        <hr>

        <button type="submit" class="btn btn-primary btn-lg mt-2" :disabled="allValidation == false ">
            <span v-if="loading">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                جاري التحميل ...
            </span>
            <span v-else>
                 حفظ
            </span>
        </button>
    </form>
  </div>
</template>

<script>

  export default {
    components: {
    },
    data() {
        return {
            titlePage:'أنشئ  مرتجع ',
            loading : false,
            costs:[],
            record:{
                quantity:'',
                employees_id:0,
                clients_id:0,
                price:'',
                order_type:'returned'
            },
        }
    },
    methods: {
        async onSubmit() {
            this.loading=true;
            let response = await this.Api('POST','returnedOrders',this.record);
            this.loading=false;
            if(response.data.status==200)
                this.$swal("تم الاضافة بنجاح", "", "success")
            if(response.data.status==416)
                this.$swal(`اجمالي الكمية المباعة لهذا العميل  = ${response.data.total_sold}`, "", "error")

        },
    },
    computed: {
        validateQuantity(){
            return this.record.quantity > 0
        },
        validatePrice(){
            return this.record.price > 0
        },
        averagePrice(){
            var cost =  this.costs.find(el=>el.production_type == this.record.production_type_id)
            return cost? cost.costs.toFixed(3) : 0;
        },
        total(){
            if(this.averagePrice){
               return parseFloat(this.record.quantity) * this.record.price;
            }
            return 0
        },
        allValidation(){
            return this.record.production_type_id > 0 &&  this.validateQuantity && this.record.employees_id && this.record.clients_id && this.record.production_type_id &&  !this.loading
        },
        profits(){
            if(this.averagePrice){
                var profits_per_one = parseFloat(this.record.price) - parseFloat(this.averagePrice)
                this.record.profits=0- parseFloat(this.record.quantity) * profits_per_one;
                return this.record.profits;
            }
            return 0
        },

    },
    async mounted(){
        let response = await this.Api('GET','getProductionPrice',{});
        this.costs= response.data;
        this.$store.state.isLoading = false;
    },
    metaInfo() {
        return {
            title: `${this.$store.state.appName} -  ${this.titlePage}`,
        }
    }

  }
</script>
