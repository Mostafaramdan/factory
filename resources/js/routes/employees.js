import employees from '@/pages/employees/index';
import create from '@/pages/employees/create';
import update from '@/pages/employees/update';
import show from '@/pages/employees/show';
const baseDash= '/dashboard';

export default [
    {
        path: `${baseDash}/employees`,
        name: `employees`,
        component: employees,
    },
    {
        path: `${baseDash}/employees/create`,
        name: `employeesCreate`,
        component: create,
    },
    {
        path: `${baseDash}/employees/update/:id`,
        name: `employeesUpdate`,
        component: update,
    },
    {
        path: `${baseDash}/employees/:id`,
        name: `employeesShow`,
        component: show,
    }
];
