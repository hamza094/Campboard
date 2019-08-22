<template>
    <div>
        
    </div>
</template>
<script>
export default{
    props:['task'],
    data(){
        return{
            
        }
    },
    methods:{
        destroy(){
                  axios.delete('/tasks/'+ this.task.id);
        
        $(this.$el).fadeOut(300,()=>{
            
        flash('Task deleted Successfully');  
            
        });
        }
    }
}

</script>