<template>
    <div class="m-3" >
    <form  @submit.prevent="onSubmit" class="border border-5 border-primary rounded form">
        <h3>
            {{titlePage}}
        </h3>
        <hr>

        <div class="form-check ">
            <label  > ادخل سعر التنزيل  </label>
            <input type="number" v-model="record.price" :class="['form-control' ,{'is-valid':validatePrice },{'is-invalid':!validatePrice}]"  >
            <div class="valid-feedback">
                     صحيح
            </div>
            <div class="invalid-feedback">
                <span>يجب إدخال الكمية بشكل صحيح</span>
            </div>
        </div>


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
            label='الموظف'
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
            titlePage:'أنشئ  فاتورة جديدة',
            loading : false,
            record:{
                employees_id:0,
                clients_id:0,
                price:0,
            },
        }
    },
    methods: {
        async onSubmit() {
            this.loading=true;
            let response = await this.Api('POST','bills',this.record);
            this.loading=false;
            if(response.data.status==200)
                this.$swal("تم الاضافة بنجاح", "", "success")

        },
    },
    computed: {
        validatePrice(){
            return this.record.price > 0
        },
        allValidation(){
            return  this.record.employees_id && this.record.clients_id && this.record.production_type_id &&  !this.loading
        }
    },
    async mounted(){
        this.$store.state.isLoading = false;
    },
    metaInfo() {
        return {
            title: `${this.$store.state.appName} -  ${this.titlePage}`,
        }
    }

  }
</script>
