<template>
<div class="flex">
	<div class="w-1/2">
		<multiselect 
		v-model="value" 
		:options="options" 
		@search-change="asyncFind" 
		@select="fatchissue" 
		:loading="isLoading"
		:hide-selected="true"
		:searchable="true"
		label="name"
		track-by="name"
		placeholder="Search Client"
		></multiselect>
	</div>
	<div class="w-1/2">
		<p>dddddddddd</p>
	</div>
</div>
</template>

<script>
import axios from 'axios'
export default {
  data () {
    return {
      value: [],
      options: [],
      isLoading: false
    }
  },
  methods: {
    async asyncFind(query){
    	var self = this;
    	if(query.length>0){
	    	this.isLoading = true
	    	let res = await axios.get('api/clientsearch/'+query)
	    	this.options = res.data
	    	this.isLoading = false
    	}
    },
    fatchissue(){
	    // let res = await axios.get('api/issueforslient/')
    }
  }
}
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

