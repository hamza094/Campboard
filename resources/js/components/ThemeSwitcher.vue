<template>
   <div class="mt-2 mr-3">
    <button v-for="(color,theme) in themes"
    class="theme-btn mr-2" 
    :class="{'border-accent':selectedTheme==theme}"
    :style="{backgroundColor:color}"
     @click="selectedTheme=theme">
     </button>
    </div>
</template>

<script>
    export default {
        data(){
        return{
            themes:{
              'theme-light':"#f5f8fa",
                'theme-dark':"#17181e"
            },
        selectedTheme:'theme-light'
        };
      },
        created(){
          this.selectedTheme=localStorage.getItem('theme') || 'theme-light'; 
        },
        watch:{
            selectedTheme(){
            document.body.className=document.body.className.replace(/theme-\w+/,this.selectedTheme);
            localStorage.setItem('theme',this.selectedTheme);    
            }
        }
    }
</script>
