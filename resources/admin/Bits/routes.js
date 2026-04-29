// import Dashboard from '../Modules/Dashboard';
import Step1 from '../Modules/Onboarding/Step1';
import Settings from '../Modules/Settings/Settings.vue';
import ViewTransaction from "../Modules/Settings/ViewTransaction.vue";
import Templates from '../Modules/Certificate/Templates';
import ManageCertificates from '../Modules/Certificate/ManageCertificates.vue';
import TemplateCustomizations from '../Modules/Certificate/TemplateCustomizations';
import ViewCertificate from '../Modules/Certificate/ViewCertificate';
import CreateCertificate from '../Modules/Certificate/CreateCertificate';
import UpdateCertificate from '../Modules/Certificate/UpdateCertificate.vue';
import EditCertificateCustomizations from '../Modules/Certificate/EditCertificateCustomizations.vue';

export default [
    {
        name: 'setup_template',
        path: '/setup_template',
        component: Step1,
        exact: true
    },
    {
        name: 'create_certificate',
        path: '/',
        component: CreateCertificate,
        exact: true
    },
    {
        name: 'templates',
        path: '/templates',
        component: Templates,
        exact: true
    },
    {
        name: 'manage_certificates',
        path: '/manage_certificates',
        component: ManageCertificates,
        exact: true
    },
    {
        name: 'update_info',
        path: '/infos/:info_id/update',
        component: UpdateCertificate,
        exact: true
    },
    {
        name: 'edit_certificate_customizations',
        path: '/infos/:info_id/edit_certificate_customizations',
        component: EditCertificateCustomizations,
        exact: true
    },
    {
        name: 'view_certificate',
        path: '/infos/:info_id/view_certificate',
        component: ViewCertificate,
        exact: true
    },
    {
        name: 'template_customizations',
        path: '/template/:template_id/template_customizations',
        component: TemplateCustomizations,
        exact: true
    },
    {
        name: 'settings',
        path: '/settings',
        component: Settings,
        exact: true
    },
    {
        name: 'view_transaction',
        path: '/settings/:transaction_id/view_transaction',
        component: ViewTransaction,
        exact: true
    },
];