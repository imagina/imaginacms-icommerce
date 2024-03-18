<style>
    /* bootstrap-modal-warehouse-locator */
    #modalWarehouseLocator {
        @media (min-width: 576px) {
            & .modal-dialog {
                max-width: 600px;
            }
        }
        & .modal-header {
              background: #ebebeb;
              border-bottom: 1px solid #969696;
            & .close {
                  font-size: 18px;
                  border: 1px solid #828282;
                  border-radius: 50%;
                  padding: 0;
                  margin: 0;
                  width: 20px;
                  height: 20px;
                  color: #828282;
                  line-height: 1.2;
                  display: flex;
                  justify-content: center;
                  align-items: center;
                  font-family: serif;
                  opacity: 1;
            }
            & .modal-title {
                font-size: 20px;
                line-height: 20px;
                border-radius: 8px 8px 0 0;
                @media (max-width: 576px) {
                    font-size: 16px;
                    line-height: 16px;
                }
            }
        }
        & .modal-body {
            & .modal-subtitle {
                font-size: 1.3em;
                margin-top: 15px;
                margin-bottom: 25px;
                font-weight: 500;
            }
            & .form-control {
                  border: 1px solid #ced4da;
                  height: 2.1em;
                  padding: 0 0.75em;
                  font-size: 1em;
            }
            & .form-home label, & .form-point label {
                color: var(--primary);
                margin-bottom: 0.2rem;
                font-weight: 500;
            }
            & .input-group-text {
                  background-color: #ced4da;
            }
            & .nav-tabs .nav-link {
                color: #212529;
                font-size: 16px;
                font-weight: 600;
            }
            & .nav-tabs .nav-link.active,
            & .nav-tabs .nav-link:hover {
                  border-top: 3px solid var(--primary);
                  color: var(--primary);
            }
            & .text-small {
              font-size: 13px;
            }
            & .item-address {
              border: 1px solid #ced4da;
              border-radius: .25rem;
              margin-bottom: 30px;
              padding: 15px;
              position: relative;
              .marked {
                  position: absolute;
                  width: 100%;
                  height: 100%;
                  border-radius: .25rem;
                  left: 0;
                  z-index: 1;
              }
              & .form-check-input {
                 z-index: 2;
              }
              &  input[type="radio"]:checked ~  .marked {
                    border: 1px solid var(--primary);
              }
            }
            &::-webkit-scrollbar {
                width: 9px;
            }
            &::-webkit-scrollbar-track {
                background: #f1f1f1;
            }
            &::-webkit-scrollbar-thumb {
                background: #969696;
            }
            &::-webkit-scrollbar-thumb:hover {
                background: #969696;
            }
            & ::placeholder {
                font-size: .9em;
            }
            & ::-ms-input-placeholder {
                font-size: .9em;
            }
        }
    
        & .btn {
              background-color: var(--primary);
              font-size: 18px;
              line-height: 17px;
              color: #fff;
              padding: 0.6em 1.1em;
              font-weight: 500;
    
            & + .btn {
              margin-left: 10px;
            }
    
            &.outline {
                 border: 1px solid var(--primary);
                 background-color: #ffffff;
                 color: var(--primary);
                &:hover {
                     background-color: var(--primary);
                     color: #fff;
                 }
            }
            &.btn-mini {
             padding: 0.4em 1.1em;
             font-size: 17px;
             line-height: 17px;
            }
        }
    
        & .create-billing-address {
            & .address-form {
                text-align: center;
            }
            & .btn-outline-primary {
                color: #ffffff !important;
            }
        }
    
    }
    #userLoginModal {
        & .modal-header {
            background: #ebebeb;
            border-bottom: 1px solid #969696;
    
            & .close {
                font-size: 18px;
                border: 1px solid #828282;
                border-radius: 50%;
                padding: 0;
                margin: 0;
                width: 20px;
                height: 20px;
                color: #828282;
                line-height: 1.2;
                display: flex;
                justify-content: center;
                align-items: center;
                font-family: serif;
                opacity: 1;
            }
            & .modal-title {
                font-size: 20px;
                line-height: 20px;
                border-radius: 8px 8px 0 0;
                @media (max-width: 576px) {
                    font-size: 16px;
                    line-height: 16px;
                }
            }
        }
        & .modal-body {
            hr, .border-bottom-dotted {
                border: 0 !important;
            }
        }
    }
</style>