import { ComponentFixture, TestBed } from '@angular/core/testing';

import { Stageadmin } from './stageadmin';

describe('Stageadmin', () => {
  let component: Stageadmin;
  let fixture: ComponentFixture<Stageadmin>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [Stageadmin],
    }).compileComponents();

    fixture = TestBed.createComponent(Stageadmin);
    component = fixture.componentInstance;
    await fixture.whenStable();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
