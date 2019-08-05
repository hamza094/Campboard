<template>
    <div>
<modal name="EditProject" height="auto">
      <div class="container mt-4">
           <p class="text-center model-heading">Edit Project</p>
           <form action="" @submit.prevent="submit">
                <div class="form-group">
                       <label for="title" class="model-text">Title</label>
                       <input type="text" class="form-control model-input" name="title" v-model="form.title">
                       <span class="text-danger font-italic" v-if="errors.title" v-text="errors.title[0]"></span>
                   </div>
                   <div class="form-group">
                       <label for="description" class="model-text">Description</label>
                       <textarea name="description" id="" cols="30" rows="4"  class="form-control model-input" v-model="form.description"> 
                           </textarea>
                        <span class="text-danger font-italic" v-if="errors.description" v-text="errors.description[0]"></span>
                   </div>
                   <div class="float-right mt-5 mb-5">
                       <button class="user-project_content_btn">Update Project</button>
                       <button class="btn-close" type="button" @click.prevent="$modal.hide('EditProject')">Cancel</button>
                   </div>
           </form>
    </div>
  </modal>
    </div>
</template>


<script>
export default{
    props:['project'],
    data(){
     return{
         form:{
        title:this.project.title,
        description:this.project.description
        },
         errors:{}
    };    
    },
    methods:{
        submit(){
            axios.patch('/projects/'+this.project.slug,{
                  title:this.form.title,
                   description:this.form.description
                })
            .then(response=>{
                
this.flash('Hello World', 'success', {
  timeout: 1000,
  beforeDestroy() {
    location.reload();
  }
});
                

            }).catch(error=>{
               this.errors=error.response.data.errors 
            });
        }
    }
   
}
</script>