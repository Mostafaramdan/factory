<template>
    <div class="m-3" v-if="this.authorized.create">
        <div  class="border border-5 border-primary rounded form">
            <h3>
                {{titlePage}}
            </h3>
            <hr>
            <div class="form-check ">
                <label  > ادخل نوع الانتاج  </label>
                <select type="text" v-model="record.production_type_id" :class="['form-control',{'is-valid':record.production_type_id > 0 },{'is-invalid':!record.production_type_id > 0}]"  >
                    <option value="1" >جبنة</option>
                    <option value="2" >خصرة</option>
                </select>
                <div class="valid-feedback">
                    صحيح
                </div>
                <div class="invalid-feedback">
                    <span>يجب إختيار نوع الانتاج   </span>
                </div>
            </div>
            <div class="form-check ">
                <label  > ادخل الكمية  </label>
                <input type="number" v-model="record.quantity" :class="['form-control']"  >
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <h6>التكاليف المتغيرة</h6>
                    <div class="table-responsive ">
                        <table class="table  table-striped table-dark table-bordered table-hover ">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">القيمة</th>
                                    <th scope="col">اجمالي ({{totalvariable_costs}})</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody  v-if="record.variable_costs && record.variable_costs.length>0 && variable_costs.length > 0">
                                <tr v-for="(variableCost,i) in record.variable_costs" :key="i" >
                                        <td>{{i+1}}</td>
                                        <td>{{variable_costs.find(element => element.id == variableCost.variable_costs_id).name}}</td>
                                        <td>{{variableCost.total}} ج</td>
                                        <td><button class="btn btn-danger"  @click="deleteVariable_costs(i)"><i class="fas fa-trash"></i></button></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td><button class="btn btn-success" @click="addVariable_costs"><i class="fas fa-plus"></i></button></td>
                                    <td>
                                        <select class="form-control" v-model="new_variable_costs">
                                            <template v-for="(variable_cost,index) in variable_costs">
                                                <option
                                                        :value="variable_cost.id"
                                                        :key="index"
                                                        v-if="!record.variable_costs.some(el => el.variable_costs_id === variable_cost.id) "
                                                >{{variable_cost.name}}</option>
                                            </template>
                                        </select>
                                    </td>
                                    <td><input class="form-control" @keyup.enter='addVariable_costs' type='number' v-model="variable_costsTotal"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6"  >
                    <h6> المواد الخام</h6>
                    <div class="table-responsive ">
                        <table class="table  table-striped table-dark table-bordered table-hover ">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">القيمة</th>
                                    <th scope="col">الكمية</th>
                                    <th scope="col">السعر</th>
                                    <th scope="col">اجمالي ({{totalproduction_materials}})</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody  v-if="record.production_materials && record.production_materials.length>0 && production_materials.length > 0">
                                <tr v-for="(productionMaterials,idx) in record.production_materials" :key="idx">
                                    <td>{{idx+1}}</td>
                                    <td>{{production_materials.find(element => element.id == productionMaterials.materials_types_id).name}}</td>
                                    <td>{{productionMaterials.quantity}} كجم</td>
                                    <td>{{productionMaterials.total / productionMaterials.quantity}} ج</td>
                                    <td>{{productionMaterials.total  }} ج</td>
                                    <td><button class="btn btn-danger" @click="deleteProduction_material(idx)"><i class="fas fa-trash"></i></button></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td><button class="btn btn-success" @click="addProduction_material"><i class="fas fa-plus"></i></button></td>
                                    <td>
                                        <select class="form-control" v-model="new_production_materials">
                                            <template v-for="(production_material,index) in production_materials">
                                                <option
                                                    :value="production_material.id" :key="index"
                                                    v-if="!record.production_materials.some(el => el.materials_types_id === production_material.id) "
                                                    >{{production_material.name}}
                                                </option>
                                            </template>
                                        </select>
                                    </td>
                                    <td><input class="form-control" @keyup.enter='addProduction_material' type='number' v-model="production_materialsPrice"></td>
                                    <td><input  @keyup.enter='addProduction_material' class="form-control" type='number' v-model="production_materialsQuantity"></td>
                                    <td>{{production_materialsQuantity*production_materialsPrice}}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <hr>
            <button type="submit" @click="onSubmit" class="btn btn-primary btn-lg mt-2" :disabled="allValidation == false ">
                <span v-if="loading">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    جاري التحميل ...
                </span>
                <span v-else>
                    حفظ
                </span>
            </button>
        </div>
    </div>
</template>

<script>

  export default {
    components: {
    },
    data() {
        return {
            titlePage:'تعديل إنتاج',
            loading : false,
            production_materials:[],
            new_production_materials:'',
            production_materialsPrice:0,
            production_materialsQuantity:0,
            variable_costs:[],
            new_variable_costs:'',
            variable_costsTotal:0,
            record:{
                name:'',
                quantity:1,
                variable_costs:[],
                production_materials:[],
            },
        }
    },
    methods: {
        async onSubmit() {
            this.loading=true;
            let response = await this.Api('PUT',`productions/${this.record.id}`,this.record);
            this.loading=false;
            this.$swal("تم التعديل بنجاح", "", "success")
        },
        addVariable_costs(){
            if(this.new_variable_costs){
                this.record.variable_costs.push({total:this.variable_costsTotal,variable_costs_id:this.new_variable_costs});
                this.variable_costsTotal='';
                this.new_variable_costs='';
            }
        },
        deleteVariable_costs(i){
            this.record.variable_costs.splice(i,1)
        },
        addProduction_material(){
            if(this.new_production_materials && this.production_materialsQuantity > 0 && this.production_materialsPrice > 0){
                this.record.production_materials.push({total:this.production_materialsPrice*this.production_materialsQuantity,quantity:this.production_materialsQuantity,materials_types_id:this.new_production_materials});
                this.production_materialsPrice='';
                this.production_materialsQuantity='';
                this.new_production_materials='';
            }
        },
        deleteProduction_material(i){
            this.record.production_materials.splice(i,1)
        }

    },
    computed: {
        validateName(){
            return this.record.name&& this.record.name.length > 3
        },
        allValidation(){
            return  this.validateName  &&  !this.loading
        },
        totalvariable_costs(){
            var total = 0;
            for(var i =0;i < this.record.variable_costs.length;i++){
                total+=parseFloat(this.record.variable_costs[i].total);
            }
            return total;
        },
        totalproduction_materials(){
            var total = 0;
            for(var i =0; i < this.record.production_materials.length;i++){
                total+= parseFloat( this.record.production_materials[i].total);
            }
            return total;
        },
    },
    async mounted(){
        this.$store.state.isLoading = false;
        let response = await this.Api('GET',`productions/${this.$route.params.id}`);
        this.record = response.data.record;
        let response1 = await this.Api('GET',`getProduction_materials`);
        this.variable_costs = response1.data.variable_costs;
        this.production_materials= response1.data.matrials_types;

    },
    metaInfo() {
        return {
            title: `${this.$store.state.appName} - ${this.titlePage}   `,
        }
    }

  }
</script>
