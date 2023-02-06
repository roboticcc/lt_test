import axios from "axios";
import router from "../../router"

const state = {
    person: {},
    people: {}
}

const getters = {
    person: state => {
        return state.person
    },
    people: state => {
        return state.people
    }
}

const mutations = {
    setPerson(state, person){
        state.person = person
    },
    setPeople(state, people){
        state.people = people
    }
}

const actions = {
    getPerson({state, commit, dispatch}, id){
        axios.get(`/api/person/${id}`)
            .then(data => {
                commit('setPerson', data.data.data)
            })
    },
    getPeople({commit}) {
        axios.get('/api/person')
            .then(data => {
                commit('setPeople', data.data.data)
            })
    },
    delete({dispatch},id) {
        axios.delete(`/api/person/${id}`)
            .then(data => {
                dispatch('getPeople')
            })
    },
    update({}, data){
        axios.patch(`/api/person/${data.id}`, {
            name: data.name,
            age: data.age,
            job: data.job,
        }).then(() => {
            router.push({
                name: `person.show`,
                params: {
                    id: data.id
                }
            })
        })
    },
    store({}, data){
        axios.post('/api/person', {
            name: data.name,
            age: data.age,
            job: data.job,
        }).then(() => {
            router.push({
                name: `person.index`
            })
        })
    }
}

export default {
    state,
    getters,
    mutations,
    actions,
}
