import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AddApartamentoComponent } from './add-apartamento.component';

describe('AddApartamentoComponent', () => {
  let component: AddApartamentoComponent;
  let fixture: ComponentFixture<AddApartamentoComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ AddApartamentoComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(AddApartamentoComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
