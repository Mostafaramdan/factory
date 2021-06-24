<template>
    <div class="m-3" v-if="this.authorized.create">
    <form @submit.prevent="onSubmit" class="border border-5 border-primary rounded ">
        <h3>
            {{titlePage}}
        </h3>
        <hr>
        <div class="form-check ">
            <label  > ادخل الاسم  </label>
            <input type="text" v-model="record.name" :class="['form-control' ,{'is-valid':validateName },{'is-invalid':!validateName}]"  >
            <div class="valid-feedback">
                     صحيح
            </div>
            <div class="invalid-feedback">
                <span>يجب إدخال الاسم بشكل صحيح</span>
            </div>
        </div>
        <div class="form-check ">
            <label  > ادخل رقم التليفون  </label>
            <input type="text" v-model="record.phone" :class="['form-control' ,{'is-valid':validatePhone },{'is-invalid':!validatePhone}]"  >
            <div class="valid-feedback">
                     صحيح
            </div>
            <div class="invalid-feedback">
                <span>يجب إدخال رقم التليفون بشكل صحيح</span>
            </div>
        </div>
        <br>
        <div class="form-check ">
            <label  > ادخل العنوان  </label>
            <textarea type="text" v-model="record.address" :class="['form-control' ,{'is-valid':validateAddress },{'is-invalid':!validateAddress}]"  ></textarea>
            <div class="valid-feedback">
                     صحيح
            </div>
            <div class="invalid-feedback">
                <span>يجب إدخال العنوان بشكل صحيح</span>
            </div>
        </div>

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
            titlePage:'أنشئ  عميل جديد',
            loading : false,
            record:{
                name:'',
                phone:0,
                address:'',
            },
        }
    },
    methods: {
        async onSubmit() {
            this.loading=true;
            let response = await this.Api('POST','clients',this.record);
            this.loading=false;
            this.record={};
            this.$swal("تم الاضافة بنجاح", "", "success")
        }
    },
    computed: {
        validateName(){
            return this.record.name && this.record.name.length > 3
        },
        validateAddress(){
            return this.record.address && this.record.address.length > 3
        },
        validatePhone(){
            return this.record.phone > 10
        },

        allValidation(){
            return this.validateAddress && this.validateName  && this.validatePhone && this.validateSalary  &&  !this.loading
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
