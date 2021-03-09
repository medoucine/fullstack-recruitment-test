import Component from './MainComponent.vue'
import { shallowMount } from '@vue/test-utils'

describe('Component', () => {
    it('Dummy', () => {
        const wrapper = shallowMount(Component)

        expect(wrapper).toBeTruthy()
    })
})