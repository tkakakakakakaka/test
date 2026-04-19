import { ComponentFixture, TestBed } from '@angular/core/testing';

import { VisiteEdit } from './visite-edit';

describe('VisiteEdit', () => {
  let component: VisiteEdit;
  let fixture: ComponentFixture<VisiteEdit>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [VisiteEdit],
    }).compileComponents();

    fixture = TestBed.createComponent(VisiteEdit);
    component = fixture.componentInstance;
    await fixture.whenStable();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
