import Cookies from 'js-cookie'
import * as types from '../mutation-types'

const { ismobile } = window.config


// state
export const state = {
	ismobile: Cookies.get('ismobile') ? Cookies.get('ismobile') : ismobile,
}

// getters
export const getters = {
	ismobile: state => state.ismobile,
}

// mutations
export const mutations = {
	[types.TOGGLE_VIEW] (state) {
		if(state.ismobile=='m'){
			state.ismobile='d';
		}else{
			state.ismobile ='m'
		}
		console.log(state.ismobile)
		Cookies.set('ismobile', state.ismobile)
	},
	[types.TOGGLE_VIEW1] (state,{m}) {
		state.ismobile=m;
		Cookies.set('ismobile', state.ismobile)
	}
}

// actions
export const actions = {
	setview ({ commit }) {
		commit(types.TOGGLE_VIEW)
	},
	setview1 ({ commit },{ m }) {
		commit(types.TOGGLE_VIEW1,{ m })
	}
}
