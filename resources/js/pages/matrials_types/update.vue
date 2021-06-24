<template>
    <div class="m-3" v-if="this.authorized.update">
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
            titlePage:'تعديل المواد الخام',
            record:{
                name:'',

            },
        }
    },
    methods: {
        async onSubmit() {
            this.loading=true;
            let response = await this.Api('PUT',`matrials_types/${this.record.id}`,this.record);
            this.loading=false;
            this.$swal("تم التعديل بنجاح", "", "success")
        }
    },
    computed: {
        validateName(){
            return this.record.name&& this.record.name.length > 3
        },
        allValidation(){
            return  this.validateName  &&  !this.loading
        }
    },
    async mounted(){
        this.$store.state.isLoading = false;
        let response = await this.Api('GET',`matrials_types/${this.$route.params.id}`);
        this.record = response.data.record;
    },
        metaInfo() {
        return {
            title: `${this.$store.state.appName} - ${this.titlePage}   `,
        }
    }

  }
</script>
