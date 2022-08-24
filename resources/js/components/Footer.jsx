import React from 'react'

export default function Footer() {
  return (
    <div>
       <footer className="content-footer footer bg-footer-theme">
          <div className="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
            <div className="mb-2 mb-md-0">
              © 2022, made with ❤️ by
              <a href="https://themeselection.com" className="footer-link fw-bolder">ThemeSelection</a>
            </div>
            <div>
              <a href="https://themeselection.com/license/" className="footer-link me-4">License</a>
              <a href="https://themeselection.com/" className="footer-link me-4">More Themes</a>

              <a
                href="https://themeselection.com/demo/sneat-bootstrap-html-admin-template/documentation/"
                className="footer-link me-4"
                >Documentation</a
              >

              <a
                href="https://github.com/themeselection/sneat-html-admin-template-free/issues"
                className="footer-link me-4"
                >Support</a
              >
            </div>
          </div>
        </footer>
    </div>
  )
}
