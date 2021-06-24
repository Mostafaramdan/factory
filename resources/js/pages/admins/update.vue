<template>
    <div class="m-3" v-if="this.authorized.update">
    <form  @submit.prevent="onSubmit" class="border border-5 border-primary rounded form">
        <h3>
         تعديل مسؤول
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
            <label  > ادخل التليفون  </label>
            <input type="number" v-model="record.phone" :class="['form-control' ,{'is-valid':validatePhone },{'is-invalid':!validatePhone}]"  >
            <div class="valid-feedback">
                     صحيح
            </div>
            <div class="invalid-feedback">
                <span>يجب إدخال التليفون  بشكل صحيح</span>
            </div>
        </div>
        <div class="form-check ">
            <label  > ادخال الرقم السري  </label>
            <input type="password" v-model="record.password" :class="['form-control' ,{'is-valid':validatePassword },{'is-invalid':!validatePassword}]"  >
            <div class="valid-feedback">
                     صحيح
            </div>
            <div class="invalid-feedback">
                <span>يجب إدخال الرقم السري بشكل صحيح</span>
            </div>
        </div>

        <div class="form-check ">
            <label  > اعد ادخال الرقم السري  </label>
            <input type="password" v-model="passwordConfirmed" :class="['form-control' ,{'is-valid':validatePassword && passwordConfirmed == record.password },{'is-invalid':!validatePassword || passwordConfirmed !== record.password}]"  >
            <div class="valid-feedback" v-if="passwordConfirmed == record.password">
                     صحيح
            </div>
            <div class="invalid-feedback" v-if="passwordConfirmed !== record.password">
                <span>الرقم السري غير متطابق</span>
            </div>
        </div>

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
            loading : false,
            passwordConfirmed:'',
            record:{
                name:'',
                email:'',
                phone:'',
                password:'',
            },
        }
    },
    methods: {
        async onSubmit() {
            this.loading=true;
            let response = await this.Api('PUT',`admins/${this.record.id}`,this.record);
            if(response.data.status==200)
                this.$swal("تم الاضافة بنجاح", "", "success")
            if(response.data.status==403)
                this.$swal("هذا الايميل موجود مسبقا ", "", "error")
            if(response.data.status==404)
                this.$swal("هذا التليفون موجود مسبقا ", "", "error")
            this.loading=false;


        },
    },
    computed: {
        validateName(){
            return this.record.name.length > 3 > 0;
        },

        validatePhone(){
            return this.record.phone.length > 3;

        },
        validatePassword(){
            if(this.record.password.length)
                return this.record.password.length > 3;
            return true;
        },
        allValidation(){
            return this.validateName  && this.validatePhone && this.validatePassword  &&  !this.loading
        }
    },
    async mounted(){
        this.$store.state.isLoading = false;
        let response = await this.Api('GET',`admins/${this.$route.params.id}`);
        this.record = response.data.record;
        this.record.password=''

    },
        metaInfo() {
        return {
            title: `${this.$store.state.appName} -   تعديل مسؤول  `,
        }
    }
}
</script>
