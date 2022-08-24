import React from 'react'
import {Link, useMatch, useResolvedPath} from "react-router-dom";

export default function SideBar() {
  return (
    <div>
        <aside id="layout-menu" className="layout-menu menu-vertical menu bg-menu-theme">
          <div className="app-brand demo">
            <Link to="/" className="app-brand-link">
              <span className="app-brand-logo demo">
              </span>
              <span className="app-brand-text demo menu-text fw-bolder ms-2">Admin Panel</span>
            </Link>
          </div>
          <div className="menu-inner-shadow"></div>
          <ul className="menu-inner py-1">
            <CustomLink to="/admins" icon="menu-icon tf-icons fas fa-users" >Adminlər</CustomLink>
            <CustomLink to="/sites" icon="menu-icon tf-icons bx fas fa-sitemap" >Sayt Parametrləri</CustomLink>
            <CustomLink to="/site-categories" icon="menu-icon tf-icons fas fa-folder">Sayt Kateqoriyaları</CustomLink>
            <CustomLink to="/banners" icon="menu-icon tf-icons fas fa-rectangle-ad">Banner Parametrləri</CustomLink>
            <CustomLink to="/logs" icon="menu-icon tf-icons fas fa-history" >Log Parametrləri</CustomLink>
          </ul>
        </aside>
    </div>
  )
}

function CustomLink({to, icon, children, ...props}) {
  const resolvedPath = useResolvedPath(to);
  const isActive = useMatch({path: resolvedPath.pathname, end:true});

  return (
    <li className={isActive ? "menu-item active" : "menu-item"}>
      <Link to={to} {...props} className="menu-link">
        <i className={icon}></i>
        <div data-i18n="Analytics">{children}</div>
      </Link>
    </li>
  )
}
