<template>
<div class="flex">
	<div class="w-1/2 p-3">
		<div class="flex">

			<div class="w-1/2 p-2">
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

			<div class="w-1/2 p-2">
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
				placeholder="Search Project"
				></multiselect>
			</div>

		</div>
	</div>
	<div class="w-1/2 p-3">
		<h2 class="font-bold bg-gray-600 p-2">Client Issue Lists</h2>
		<table class="w-full bg-white" v-if="clientissue">
		   <tbody>
		   		<tr>
		   			<th class="p-2 border border-gray-200 text-sm text-left">NO</th>
		   			<th class="p-2 border border-gray-200 text-sm text-left">Status</th>
		   			<th class="p-2 border border-gray-200 text-sm text-left">Creation</th>
		   			<th class="p-2 border border-gray-200 text-sm text-left">Issue Title</th>
		   			<th class="p-2 border border-gray-200 text-sm text-left">Issue Details</th>
		   		</tr>
                <tr v-for="issue in clientissue">
                    <td class="p-2 border border-gray-200 text-sm">
                        Admin
                    </td>
                    <td class="p-2 border border-gray-200 text-sm">
                        Admin
                    </td>
                    <td class="p-2 border border-gray-200 text-sm">
                        Admin
                    </td>
                    <td class="p-2 border border-gray-200 text-sm">
                        Admin
                    </td>
                    <td class="p-2 border border-gray-200 text-sm">
                        Admin
                    </td>
                </tr>
            </tbody>
        </table>
	</div>
</div>
</template>

<script>
import axios from 'axios'
export default {
  middleware: 'auth',
  data () {
    return {
      value: [],
      options: [],
      isLoading: false,
      clientissue:[]
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
    async fatchissue(client){
	    let res = await axios.get('api/issueforslient/'+client.id)
	    this.clientissue=res.data;
    }
  }
}
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

