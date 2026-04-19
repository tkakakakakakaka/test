import { ComponentFixture, TestBed } from '@angular/core/testing';

import { SoutenancesForm } from './soutenances-form';

describe('SoutenancesForm', () => {
  let component: SoutenancesForm;
  let fixture: ComponentFixture<SoutenancesForm>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [SoutenancesForm],
    }).compileComponents();

    fixture = TestBed.createComponent(SoutenancesForm);
    component = fixture.componentInstance;
    await fixture.whenStable();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
