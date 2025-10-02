<script setup>
import { ref, onMounted, watch, onBeforeUnmount } from 'vue'
import { RouterView, useRoute } from 'vue-router'

const url = window.location.origin;

const route = useRoute();

const sidebarOpen = ref(true);
const isMobile = ref(false);


const toggleSidebar = () => {
  sidebarOpen.value = !sidebarOpen.value;
};

const handleResize = () => {
  isMobile.value = window.innerWidth < 1200; // Bootstrap xl breakpoint
  if (isMobile.value) sidebarOpen.value = false;
};


const menuItems = [
  {
    key: 'home',
    label: 'Home',
    to: '/',
    icon: 'ri ri-home-smile-line',
    children: [
      {
        label: 'Dashboard',
        to: '/',
        icon: 'ri ri-dashboard-line',
      },
      {
        label: 'Attendence Record',
        to: '/attendence-record',
        icon: 'ri ri-calendar-line',
      },
      {
        label: 'Leave Request',
        to: '/leave-request',
        icon: 'ri ri-calendar-line',
      },
      {
        label: 'User Account',
        to: '/user-account',
        icon: 'ri ri-user-line',
      },
    ],
  },
  {
    key: 'reports',
    label: 'Reports',
    to: '/reports',
    icon: 'ri ri-file-chart-line',
    children: [
      {
        label: 'Monthly Report',
        to: '/monthly-report',
        icon: 'ri ri-calendar-line',
      },
      {
        label: 'Annual Report',
        to: '/annual-report',
        icon: 'ri ri-calendar-line',
      },
    ],
  },

];

const dropdowns = ref({});
//initial dropdowns states
menuItems.forEach(item => {
  dropdowns.value[item.key] = false;
});

const toggleDropdown = (key) => {
  for (const k in dropdowns.value) {
    dropdowns.value[k] = k === key ? !dropdowns.value[k] : false;
  }
}

const isActive = (path) => route.path === path;

const hasActiveChild = (children) => {
  return children?.some(child => isActive(child.to));
}

// Auto-expand correct menu on load and route change
const expandActiveMenu = () => {
  for (const item of menuItems) {
    dropdowns.value[item.key] = isActive(item.to) || hasActiveChild(item.children);

  }
}

onMounted(expandActiveMenu);
watch(() => route.path, expandActiveMenu);

onMounted(() => {
  handleResize();
  window.addEventListener('resize', handleResize);
});

onBeforeUnmount(() => {
  window.removeEventListener('resize', handleResize);
});

</script>

<template>

  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar  ">
    <div class="layout-container">

      <!-- Menu -->
      <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme" :class="[
        isMobile ? 'mobile-sidebar' : '',
        sidebarOpen ? 'show-sidebar' : 'hide-sidebar',
        'fixed-sidebar'
      ]">

        <div class="app-brand demo ">
          <RouterLink to="/" class="app-brand-link">
            <span class="app-brand-logo demo me-1">
              <img :src="url + '/assets/img/logo/fortelogo.png'" alt="Logo" width="150" height="110" />
            </span>
          </RouterLink>

        </div>

        <div class="menu-inner-shadow"></div>

        <ul class="menu-inner py-1">
          <li v-for="item in menuItems" :key="item.key" :class="[
            'menu-item',
            dropdowns[item.key] ? 'open' : '',
            isActive(item.to) || hasActiveChild(item.children) ? 'active' : ''
          ]">
            <!-- Main Menu Link -->
            <div class="menu-link menu-toggle" @click="toggleDropdown(item.key)">
              <i :class="['menu-icon icon-base', item.icon]"></i>
              <div :data-i18n="item.label">{{ item.label }}</div>
            </div>

            <!-- Submenu -->
            <ul class="menu-sub" :class="{ show: dropdowns[item.key] }">
              <li v-for="sub in item.children" :key="sub.to" :class="['menu-item', isActive(sub.to) ? 'active' : '']">
                <RouterLink :to="sub.to" class="menu-link" @click.stop>
                  <i :class="['menu-icon icon-base', sub.icon]"></i>
                  <div :data-i18n="sub.label">{{ sub.label }}</div>
                </RouterLink>
              </li>
            </ul>
          </li>
        </ul>

      </aside>
      <!-- / Menu -->

      <!-- Layout container -->
      <div class="layout-page">

        <!-- Navbar -->

        <nav
          class="layout-navbar container-xxl navbar-detached navbar navbar-expand-xl align-items-center bg-navbar-theme fixed-navbar"
          id="layout-navbar">

          <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
              <i class="icon-base ri ri-menu-line icon-md" @click="toggleSidebar"></i>
            </a>
          </div>


          <div class="navbar-nav-right d-flex align-items-center justify-content-end" id="navbar-collapse">



            <!-- Search -->
            <div class="navbar-nav align-items-center gap-2">

              <div class="nav-item d-flex align-items-center">

                <i class="icon-base ri ri-search-line icon-lg lh-0"></i>
                <input type="text" class="form-control border-0 shadow-none" placeholder="Search..."
                  aria-label="Search...">
              </div>
            </div>
            <!-- /Search -->


            <ul class="navbar-nav flex-row align-items-center ms-md-auto">


              <!-- Place this tag where you want the button to render. -->
              <li class="nav-item lh-1 me-4">
                <a class="github-button" href="#" data-icon="octicon-star" data-size="large"
                  data-show-count="true">Star</a>
              </li>

              <!-- User -->
              <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown">
                  <div class="avatar avatar-online">
                    <img :src="url + '/assets/img/avatars/1.png'" alt="alt" class="rounded-circle">
                  </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                  <li>
                    <a class="dropdown-item" href="#">
                      <div class="d-flex">
                        <div class="flex-shrink-0 me-3">
                          <div class="avatar avatar-online">
                            <img :src="url + '/assets/img/avatars/1.png'" alt="alt"
                              class="w-px-40 h-auto rounded-circle">
                          </div>
                        </div>
                        <div class="flex-grow-1">
                          <h6 class="mb-0">John Doe</h6>
                          <small class="text-body-secondary">Admin</small>
                        </div>
                      </div>
                    </a>
                  </li>
                  <li>
                    <div class="dropdown-divider my-1"></div>
                  </li>
                  <li>
                    <a class="dropdown-item" href="#">
                      <i class="icon-base ri ri-user-line icon-md me-3"></i>
                      <span>My Profile</span>
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="#">
                      <i class="icon-base ri ri-settings-4-line icon-md me-3"></i>
                      <span>Settings</span>
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="#">
                      <span class="d-flex align-items-center align-middle">
                        <i class="flex-shrink-0 icon-base ri ri-bank-card-line icon-md me-3"></i>
                        <span class="flex-grow-1 align-middle ms-1">Billing Plan</span>
                        <span class="flex-shrink-0 badge rounded-pill bg-danger">4</span>
                      </span>
                    </a>
                  </li>
                  <li>
                    <div class="dropdown-divider my-1"></div>
                  </li>
                  <li>
                    <div class="d-grid px-4 pt-2 pb-1">
                      <a class="btn btn-danger d-flex" href="javascript:void(0);">
                        <small class="align-middle">Logout</small>
                        <i class="ri ri-logout-box-r-line ms-2 ri-xs"></i>
                      </a>
                    </div>
                  </li>
                </ul>
              </li>
              <!--/ User -->

            </ul>
          </div>

        </nav>

        <!-- / Navbar -->

        <!-- Content wrapper -->
        <div class="content-wrapper">
          <!-- Content -->
          <div class="container-xxl flex-grow-1 container-p-y">
            <!--Remote Componenet show here-->
            <router-view></router-view>

          </div>
          <!-- / Content -->

          <!-- Footer -->
          <footer class="content-footer footer bg-footer-theme fixed-footer">
            <div class="container-xxl">
              <div
                class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
                <div class="mb-2 mb-md-0">

                </div>
                <div class="d-none d-lg-inline-block">
                  <a href="#" class="footer-link">Edited By: IT Department</a>
                </div>
              </div>
            </div>
          </footer>
          <!-- / Footer -->


          <div class="content-backdrop fade"></div>
        </div>
        <!-- Content wrapper -->
      </div>
      <!-- / Layout page -->
    </div>

    <!-- Overlay -->

    <div v-if="sidebarOpen && isMobile" class="layout-overlay layout-menu-toggle" @click="toggleSidebar"></div>

  </div>
  <!-- / Layout wrapper -->
</template>

<style scoped>
/* Mobile Sidebar Slide */
.mobile-sidebar {
  position: fixed;
  top: 0;
  left: 0;
  height: 100vh;
  width: 250px;
  z-index: 1045;
  transition: transform 0.3s ease;
  box-shadow: 2px 0 10px rgba(0, 0, 0, 0.2);
}

.hide-sidebar.mobile-sidebar {
  transform: translateX(-100%);
}

.show-sidebar.mobile-sidebar {
  transform: translateX(0);
}

/* Backdrop */
.layout-overlay.layout-menu-toggle {
  position: fixed;
  top: 0;
  left: 0;
  z-index: 1040;
  width: 100vw;
  height: 100vh;
  background: rgba(0, 0, 0, 0.4);
}

.fixed-sidebar {
  position: fixed;
  top: 0;
  left: 0;
  height: 100vh;
  overflow-y: auto;
  z-index: 1045;
}


.layout-page {

  margin-left: 250px; /* sidebar width */
  padding-top: 64px;  /* navbar height */
  display: flex;
  flex-direction: column;
  min-height: 100vh;

}

@media (max-width: 1199.98px) {
  .layout-page {
    margin-left: 0;
  }
}


.content-wrapper {
  flex: 1;
  overflow-y: auto;
  padding-bottom: 80px; /* space for footer */
}


.fixed-footer {
  position: relative;
  bottom: 0;
  width: 100%;
  z-index: 1020;
  background-color: #f8f9fa;
  padding: 1rem 0;
}


.fixed-navbar {
  position: sticky;
  top: 0;
  left: 0;
  right: 0;
  z-index: 1050;
  height: 64px; /* adjust based on your navbar height */

}

</style>
