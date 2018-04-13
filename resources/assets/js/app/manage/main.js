import Vue from 'vue';

export var user = null;
export const EventBus = new Vue();
window.EventBus = EventBus;
