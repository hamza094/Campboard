<template>
   <div>
       <modal name="project" height="auto">
          <div class="container mt-4">
           <p class="text-center model-heading">Let's start something new</p>
           <form @submit.prevent="submit">
           <div class="row">
               <div class="col-md-6">
                   <div class="form-group">
                       <label for="title" class="model-text">Title</label>
                       <input type="text" class="form-control model-input" name="title" v-model="form.title"
                       :class="errors.title ?'border border-danger':''">
                       <span class="text-danger font-italic" v-if="errors.title" v-text="errors.title[0]"></span>
                   </div>
                   <div class="form-group">
                       <label for="description" class="model-text">Description</label>
                       <textarea name="description" id="" cols="30" rows="4"  class="form-control model-input"
                           v-model="form.description"
                            :class="errors.description ?'border border-danger':''"> 
                           ></textarea>
                        <span class="text-danger font-italic" v-if="errors.description" v-text="errors.description[0]"></span>
                   </div>
               </div>
               <div class="col-md-6 position">
                   <div class="form-group">
                       <label for="task" class="model-text">Need Some Tasks?</label>
                       <input type="text" class="form-control model-input mb-2" placeholder="Task..." 
                       name="task"
                        v-for="task in form.tasks"
                        v-model="task.body">
                   </div>
                   <button class="model-task-btn" type="button" @click.prevent="addTask"><i class="fas fa-plus-circle"></i> Add new Task Field</button>
                   <div class="float-right model-btn">
                       <button class="user-project_content_btn">Create Project</button>
                       <button class="btn-close" type="button" @click.prevent="$modal.hide('project')">Cancel</button>
                   </div>
               </div>
           </div> 
              </form>  
          </div>
           
       </modal>
   </div>
</template>

<script>
    export default {
       data(){
           return{
               form:{
                   title:'',
                   description:'',
                  tasks:[
                 {body:''}
             ]    
            },
            errors:{}
           };
       },
        methods:{
      addTask(){
          this.form.tasks.push({value:''});
      },
        submit(){
            axios.post('/projects',this.form)
            .then(response=>{
                location=response.data.message;
            }).catch(error=>{
                this.errors=error.response.data.errors;
            });
        }    
    },
    }
</script>