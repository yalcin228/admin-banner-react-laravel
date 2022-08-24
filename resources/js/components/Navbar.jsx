import React from 'react'
import DropDown from './DropDown';

export default function Navbar() {


    return (
        <div>
            <nav
                className="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                id="layout-navbar">
                <div className="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                    <a className="nav-item nav-link px-0 me-xl-4" href="">
                        <i className="bx bx-menu bx-sm"></i>
                    </a>
                </div>

                <div className="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                    <h3 className="navbar-nav align-items-center">Admin Panel xos gelmisiniz</h3>
                    <ul className="navbar-nav flex-row align-items-center ms-auto">
                        <DropDown />
                    </ul>
                </div>
            </nav>
        </div>
    )
}
