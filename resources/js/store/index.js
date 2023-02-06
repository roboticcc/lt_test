import { createStore } from 'vuex'
import Person from './modules/person'

const store = createStore({
    modules: {
        Person
    }
})

export default store
