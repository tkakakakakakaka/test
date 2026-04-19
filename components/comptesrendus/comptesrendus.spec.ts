import { ComponentFixture, TestBed } from '@angular/core/testing';

import { Comptesrendus } from './comptesrendus';

describe('Comptesrendus', () => {
  let component: Comptesrendus;
  let fixture: ComponentFixture<Comptesrendus>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [Comptesrendus],
    }).compileComponents();

    fixture = TestBed.createComponent(Comptesrendus);
    component = fixture.componentInstance;
    await fixture.whenStable();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
