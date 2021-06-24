import variable_costs from '@/pages/variable_costs/index';
import create from '@/pages/variable_costs/create';
import update from '@/pages/variable_costs/update';
import show from '@/pages/variable_costs/show';
const baseDash= '/dashboard';

export default [
    {
        path: `${baseDash}/variable_costs`,
        name: `variable_costs`,
        component: variable_costs,
    },
    {
        path: `${baseDash}/variable_costs/create`,
        name: `variable_costsCreate`,
        component: create,
    },
    {
        path: `${baseDash}/variable_costs/update/:id`,
        name: `variable_costsUpdate`,
        component: update,
    },
    {
        path: `${baseDash}/variable_costs/:id`,
        name: `variable_costsShow`,
        component: show,
    }
];
