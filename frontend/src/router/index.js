import { createRouter, createWebHistory } from 'vue-router'
import Dashboard from '../views/Dashboard.vue'
import AttendenceRecord from '../views/hr/AttendenceRecord.vue'
import UserAccount from '../views/UserAccount.vue'
import LeaveRequest from '../views/hr/Leave-request.vue'
import Employees from '../views/hr/Employees.vue'
import Departments from '../views/hr/Departments.vue'
import Positions from '../views/hr/Positions.vue'


const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: '',
      component: Dashboard,
    },
    {
      path: '/attendence-record',
      name: 'AttendenceRecord',
      component: AttendenceRecord,
    },
    {
      path: '/user-account',
      name: 'UserAccount',
      component: UserAccount,
    },
    {
      path: '/leave-request',
      name: 'LeaveRequest',
      component: LeaveRequest,
    },
    {
      path: '/employees',
      name: 'Employees',
      component: Employees,
    },
    {
      path: '/department',
      name: 'Department',
      component: Departments,
    },
    {
      path: '/position',
      name: 'Position',
      component: Positions,
    }

  ],
})

export default router
