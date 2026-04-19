import { ComponentFixture, TestBed } from '@angular/core/testing';

import { SoutenanceEdit } from './soutenance-edit';

describe('SoutenanceEdit', () => {
  let component: SoutenanceEdit;
  let fixture: ComponentFixture<SoutenanceEdit>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [SoutenanceEdit],
    }).compileComponents();

    fixture = TestBed.createComponent(SoutenanceEdit);
    component = fixture.componentInstance;
    await fixture.whenStable();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
